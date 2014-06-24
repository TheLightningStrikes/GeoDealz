package com.geodealz.geodeals;

import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.IntentFilter;
import android.nfc.NdefMessage;
import android.nfc.NdefRecord;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.nfc.tech.MifareClassic;
import android.nfc.tech.Ndef;
import android.nfc.tech.NfcF;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Parcelable;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ListView;
import android.widget.TextView;

import com.geodealz.geodeals.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;

public class NFCActivity extends Activity {
    String deal_id = "";
    private ArrayList<HashMap<String, String>> testList;
    {
        testList = new ArrayList<HashMap<String, String>>();
    }

    @Override
    public void onCreate(Bundle savedState) {
        super.onCreate(savedState);

        setContentView(R.layout.activity_nfc);

        Intent intent = getIntent();
        String message = "";

        Parcelable[] rawMsgs = intent.getParcelableArrayExtra(NfcAdapter.EXTRA_NDEF_MESSAGES);
        if (rawMsgs != null) {
            NdefMessage[] msgs = new NdefMessage[rawMsgs.length];
            for (int i = 0; i < rawMsgs.length; i++) {
                msgs[i] = (NdefMessage) rawMsgs[i];
                message = new String(msgs[i].getRecords()[0].getPayload());
            }
        }
        deal_id = message.substring(3, message.length());

        new getDeal().execute();
    }


    private class getDeal extends AsyncTask<Void, Void, Void> {
        @Override
        protected Void doInBackground(Void... arg0) {
            // Creating service handler class instance
            ServiceHandler sh = new ServiceHandler();

            // Making a request to url and getting response
            String jsonStr = sh.makeServiceCall("http://www.geodeals.tk/admin/api/deals/deal/" + deal_id, ServiceHandler.GET);

            if (jsonStr != null) {
                try {
                    JSONArray jsonObj = new JSONArray(jsonStr);

                    // looping through All Contacts
                    for (int i = 0; i < jsonObj.length(); i++) {
                        JSONObject c = jsonObj.getJSONObject(i);

                        String bedrijf = c.getString("bedrijf");
                        String afbeelding = c.getString("deal");
                        String omschrijving = c.getString("omschrijving");

                        // tmp hashmap for single evenementHM
                        HashMap<String, String> evenementHM = new HashMap<String, String>();

                        // adding each child node to HashMap key => value
                        evenementHM.put("bedrijf", bedrijf);
                        evenementHM.put("afbeelding", afbeelding);
                        evenementHM.put("omschrijving", omschrijving);

                        // adding evenementHM to evenementHM list
                        testList.add(evenementHM);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Log.e("ServiceHandler", "Couldn't get any data from the url");
            }
            System.out.println(testList);
            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            super.onPostExecute(result);

            Bundle data = new Bundle();

            data.putString("bedrijf", testList.get(0).get("bedrijf"));
            data.putString("afbeelding", testList.get(0).get("afbeelding"));
            data.putString("omschrijving", testList.get(0).get("omschrijving"));
            data.putString("deal_id", deal_id);

            Fragment frag = new EventDetailsListFragmentDeal();

            frag.setArguments(data);

            FragmentManager fm = getFragmentManager();
            FragmentTransaction ft = fm.beginTransaction();

            ft.replace(R.id.deal_fragment, frag);
            ft.commit();
        }
    }
}