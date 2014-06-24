package com.geodealz.geodeals;

import android.app.ActionBar;
import android.app.AlertDialog;
import android.app.FragmentTransaction;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.location.LocationManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.provider.Settings;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.app.NotificationCompat;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.Toast;

public class MainActivity extends FragmentActivity implements ActionBar.TabListener {
    AppSectionsPagerAdapter mAppSectionsPagerAdapter;
    ViewPager mViewPager;
    SharedPreferences prefs = null;
    final String key = "com.geodealz.geodeals.locationChecked";
    boolean locationEnabled;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        mAppSectionsPagerAdapter = new AppSectionsPagerAdapter(getSupportFragmentManager());

        final ActionBar actionBar = getActionBar();

        actionBar.setHomeButtonEnabled(false);

        actionBar.setNavigationMode(ActionBar.NAVIGATION_MODE_TABS);

        mViewPager = (ViewPager) findViewById(R.id.pager);
        mViewPager.setAdapter(mAppSectionsPagerAdapter);
        mViewPager.setOnPageChangeListener(new ViewPager.SimpleOnPageChangeListener() {
            @Override
            public void onPageSelected(int position) {
                actionBar.setSelectedNavigationItem(position);
            }
        });

        // Voeg voor elke tab een actionbar toe.
        for (int i = 0; i < mAppSectionsPagerAdapter.getCount(); i++) {
            actionBar.addTab(
                actionBar.newTab()
                    .setText(mAppSectionsPagerAdapter.getPageTitle(i))
                    .setTabListener(this));
        }

        prefs = this.getSharedPreferences("com.geodealz.geodeals", Context.MODE_PRIVATE);
        locationEnabled = prefs.getBoolean(key, true);
        if (locationEnabled) {
            Intent i = new Intent(this, LocationDealAlertService.class);
            this.startService(i);
        }

        LocationManager locationManager = (LocationManager) getSystemService(LOCATION_SERVICE);
        if (locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER) | locationManager.isProviderEnabled(LocationManager.NETWORK_PROVIDER) ){
        }else{
            showGPSDisabledAlertToUser();
        }

        if (!haveInternet(getApplicationContext())){
            showInternetDisabledAlertToUser();
        }

        setPersistentNotification();
    }

    private void showInternetDisabledAlertToUser(){
        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(this);
        alertDialogBuilder.setMessage("Activeer alstublieft uw internetverbinding om GeoDeals te gebruiken.")
            .setCancelable(false)
            .setPositiveButton("Open WIFI instellingen",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        Intent callGPSSettingIntent = new Intent(
                            Settings.ACTION_WIFI_SETTINGS);
                        startActivity(callGPSSettingIntent);
                    }
                }
            );
        alertDialogBuilder.setNeutralButton("Open mobiele data instellingen",
            new DialogInterface.OnClickListener() {
                public void onClick(DialogInterface dialog, int id) {
                    Intent callGPSSettingIntent = new Intent(
                        Settings.ACTION_DATA_ROAMING_SETTINGS);
                    startActivity(callGPSSettingIntent);
                }
            });
        AlertDialog alert = alertDialogBuilder.create();
        alert.show();
    }

    private void showGPSDisabledAlertToUser(){
        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(this);
        alertDialogBuilder.setMessage("Activeer alstublieft uw locatievoorzieningen voor optimaal gebruik van GeoDeals.")
            .setCancelable(false)
            .setPositiveButton("Open locatie instellingen",
                    new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            Intent callGPSSettingIntent = new Intent(
                                    android.provider.Settings.ACTION_LOCATION_SOURCE_SETTINGS);
                            startActivity(callGPSSettingIntent);
                        }
                    }
            );
        alertDialogBuilder.setNegativeButton("Annuleren",
            new DialogInterface.OnClickListener(){
                public void onClick(DialogInterface dialog, int id){
                    dialog.cancel();
                }
            });
        AlertDialog alert = alertDialogBuilder.create();
        alert.show();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu items for use in the action bar
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.actionbar_actions, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle presses on the action bar items
        switch (item.getItemId()) {
            case R.id.action_settings:
                Intent i = new Intent(this, SettingsActivity.class);
                startActivity(i);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onDestroy() {
        CancelNotification(getApplicationContext(),002);
        if (locationEnabled) {
            Intent i = new Intent(this, LocationDealAlertService.class);
            this.stopService(i);
        }
        super.onDestroy();
    }

    @Override
    public void onPause() {
        super.onPause();
    }

    public void setPersistentNotification(){
        if (locationEnabled) {
            NotificationCompat.Builder mBuilder =
                new NotificationCompat.Builder(getApplicationContext())
                    .setSmallIcon(R.drawable.ic_launcher)
                    .setContentTitle("GeoDeals")
                    .setOngoing(true)
                    .setContentText("Locatie Deals worden automatisch gezocht!");


            Intent resultIntent = new Intent(this, SettingsActivity.class);
            // Because clicking the notification opens a new ("special") activity, there's
            // no need to create an artificial back stack.
            PendingIntent resultPendingIntent =
                PendingIntent.getActivity(
                    this,
                    0,
                    resultIntent,
                    PendingIntent.FLAG_UPDATE_CURRENT
                );

            mBuilder.setContentIntent(resultPendingIntent);

            // Sets an ID for the notification
            int mNotificationId = 002;
            // Gets an instance of the NotificationManager service
            NotificationManager mNotifyMgr = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
            // Builds the notification and issues it.
            mNotifyMgr.notify(mNotificationId, mBuilder.build());
        }
    }
    @Override
    public void onResume() {
        super.onResume();
    }

    @Override
    public void onTabUnselected(ActionBar.Tab tab, FragmentTransaction fragmentTransaction) {
    }

    @Override
    public void onTabSelected(ActionBar.Tab tab, FragmentTransaction fragmentTransaction) {
        mViewPager.setCurrentItem(tab.getPosition());
    }

    @Override
    public void onTabReselected(ActionBar.Tab tab, FragmentTransaction fragmentTransaction) {
    }

    public static class AppSectionsPagerAdapter extends FragmentPagerAdapter {

        public AppSectionsPagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public Fragment getItem(int i) {
            switch (i) {
                case 0:
                    Fragment fragment = new EventFragment();
                    Bundle args = new Bundle();
                    args.putInt(EventFragment.ARG_SECTION_NUMBER, i + 1);
                    fragment.setArguments(args);
                    return fragment;
                case 1:
                    return new NFCkaartFragment();
                default:
                    return null;
            }
        }

        // Aantal tabs
        @Override
        public int getCount() {
            return 2;
        }

        // Titels tabs
        @Override
        public CharSequence getPageTitle(int position) {
            switch (position) {
                case 0:
                    return "Evenementen";
                case 1:
                    return "NFC Kaart";
                default:
                    return "Error";
            }
        }
    }

    public static void CancelNotification(Context ctx, int notifyId) {
        String ns = Context.NOTIFICATION_SERVICE;
        NotificationManager nMgr = (NotificationManager) ctx.getSystemService(ns);
        nMgr.cancel(notifyId);
    }

    public static boolean haveInternet(Context ctx) {
        NetworkInfo info = (NetworkInfo) ((ConnectivityManager) ctx
                .getSystemService(Context.CONNECTIVITY_SERVICE)).getActiveNetworkInfo();

        if (info == null || !info.isConnected()) {
            return false;
        }
        return true;
    }
}