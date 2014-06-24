package com.geodealz.geodeals;

import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.app.ListFragment;
import android.app.NotificationManager;
import android.content.Context;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;

public class NotificationDealActivity extends Activity {
    String omschrijving = "";
    String bedrijf = "";
    String afbeelding = "";
    String deal_id = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notification_deal);
        setWaardes();

        cancelNotification(getApplicationContext(),001);
        Bundle data = new Bundle();

        data.putString("omschrijving", omschrijving);
        data.putString("bedrijf", bedrijf);
        data.putString("afbeelding", afbeelding);
        data.putString("deal_id", deal_id);

        Fragment frag = new EventDetailsListFragmentDeal();

        frag.setArguments(data);

        FragmentManager fm = getFragmentManager();
        FragmentTransaction ft = fm.beginTransaction();

        ft.replace(R.id.deal_fragment, frag);
        ft.commit();
    }

    @Override
    public void onResume() {
        super.onResume();
        setWaardes();
    }

    public void setWaardes() {
        Bundle extras = getIntent().getExtras();
        if(extras == null) {
            Log.d("Error", "Extras = null");
        } else {
            this.omschrijving = extras.getString("omschrijving");
            this.bedrijf = extras.getString("bedrijf");
            this.afbeelding = extras.getString("afbeelding");
            this.deal_id = extras.getString("deal_id");
        }
    }

    public static void cancelNotification(Context ctx, int notifyId) {
        String ns = Context.NOTIFICATION_SERVICE;
        NotificationManager nMgr = (NotificationManager) ctx.getSystemService(ns);
        nMgr.cancel(notifyId);
    }
}