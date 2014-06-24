package com.geodealz.geodeals;

import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.util.ArrayList;
import java.util.HashMap;

import android.app.AlertDialog;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.app.Service;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.IBinder;
import android.support.v4.app.NotificationCompat;
import android.util.Log;
import android.widget.ListView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class LocationDealAlertService extends Service {

    private static final long MINIMUM_DISTANCECHANGE_FOR_UPDATE = 1; // Meters
    private static final long MINIMUM_TIME_BETWEEN_UPDATE = 10000; // Milliseconds

    private static final NumberFormat nf = new DecimalFormat("##.########");

    private LocationManager locationManager;
    private LocationListener locationListener;

    private ArrayList<HashMap<String, String>> testList;
    {
        testList = new ArrayList<HashMap<String, String>>();
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        return super.onStartCommand(intent, flags, startId);
    }

    public void onCreate() {
        this.locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        this.locationListener = new MyLocationListener();

        locationManager.requestLocationUpdates(
                LocationManager.GPS_PROVIDER,
                MINIMUM_TIME_BETWEEN_UPDATE,
                MINIMUM_DISTANCECHANGE_FOR_UPDATE,
                locationListener
        );

        new getLocationDeals().execute();
        super.onCreate();
    }

    public void onDestroy() {
        locationManager.removeUpdates(locationListener);
        locationManager = null;
        super.onDestroy();
    }

    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    public class MyLocationListener implements LocationListener {
        public void onLocationChanged(Location location) {
            for (int i = 0; i < testList.size(); i++){
                Location pointLocation = new Location("pointLocation");
                pointLocation.setLatitude(Double.parseDouble(testList.get(i).get("x")));
                pointLocation.setLongitude(Double.parseDouble(testList.get(i).get("y")));

                float distance = location.distanceTo(pointLocation);
                // Toast.makeText(LocationDealAlertService.this,"Afstand tot deal: "+distance, Toast.LENGTH_LONG).show();
                if (distance < 100) {
                    NotificationCompat.Builder mBuilder =
                        new NotificationCompat.Builder(getApplicationContext())
                            .setSmallIcon(R.drawable.ic_launcher)
                            .setContentTitle(testList.get(i).get("naam"))
                            .setContentText(testList.get(i).get("bedrijf"));

                    Intent resultIntent = new Intent(getApplication(), NotificationDealActivity.class);

                    resultIntent.putExtra("omschrijving", testList.get(i).get("omschrijving"));
                    resultIntent.putExtra("bedrijf", testList.get(i).get("bedrijf"));
                    resultIntent.putExtra("afbeelding", testList.get(i).get("afbeelding"));
                    resultIntent.putExtra("deal_id", testList.get(i).get("deal_id"));

                    // Because clicking the notification opens a new ("special") activity, there's
                    // no need to create an artificial back stack.
                    PendingIntent resultPendingIntent =
                        PendingIntent.getActivity(
                            getApplication(),
                            0,
                            resultIntent,
                            PendingIntent.FLAG_UPDATE_CURRENT
                        );

                    mBuilder.setContentIntent(resultPendingIntent);

                    // Sets an ID for the notification
                    int mNotificationId = 001;
                    // Gets an instance of the NotificationManager service
                    NotificationManager mNotifyMgr = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
                    // Builds the notification and issues it.
                    mNotifyMgr.notify(mNotificationId, mBuilder.build());
                }
            }
            // Location pointLocation = retrievelocationFromPreferences();




//            Log.d("LAT: ", nf.format(location.getLatitude()));
//            Log.d("LON: ", nf.format(location.getLongitude()));
        }
        public void onStatusChanged(String s, int i, Bundle b) {
        }
        public void onProviderDisabled(String s) {
        }
        public void onProviderEnabled(String s) {
        }
    }

    private class getLocationDeals extends AsyncTask<Void, Void, Void> {
        @Override
        protected Void doInBackground(Void... arg0) {
            // Creating service handler class instance
            ServiceHandler sh = new ServiceHandler();

            // Making a request to url and getting response
            String jsonStr = sh.makeServiceCall("http://www.geodeals.tk/admin/api/deals/location", ServiceHandler.GET);

            if (jsonStr != null) {
                try {
                    JSONArray jsonObj = new JSONArray(jsonStr);

                    // looping through All Contacts
                    for (int i = 0; i < jsonObj.length(); i++) {
                        JSONObject c = jsonObj.getJSONObject(i);

                        String naam = c.getString("naam");
                        String omschrijving = c.getString("omschrijving");
                        String afbeelding = c.getString("deal");
                        String bedrijf = c.getString("bedrijf");
                        String deal_id = c.getString("deal_id");
                        String x = c.getString("x");
                        String y = c.getString("y");

                        // tmp hashmap for single evenementHM
                        HashMap<String, String> evenementHM = new HashMap<String, String>();

                        // adding each child node to HashMap key => value
                        evenementHM.put("naam", naam);
                        evenementHM.put("afbeelding", afbeelding);
                        evenementHM.put("omschrijving", omschrijving);
                        evenementHM.put("bedrijf", bedrijf);
                        evenementHM.put("deal_id", deal_id);
                        evenementHM.put("x", x);
                        evenementHM.put("y", y);

                        // adding evenementHM to evenementHM list
                        testList.add(evenementHM);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Log.e("ServiceHandler", "Couldn't get any data from the url");
            }
            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            super.onPostExecute(result);
        }
    }
}