package com.geodealz.geodeals;

import android.app.Activity;
import android.content.Context;
import android.graphics.Point;
import android.graphics.drawable.BitmapDrawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.PopupWindow;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

public class NFCkaartFragment extends Fragment {
    private GoogleMap map;
    ImageView afbeelding;
    private ArrayList<HashMap<String, String>> testList;
    {
        testList = new ArrayList<HashMap<String, String>>();
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.fragment_nfckaart, container, false);

        new getNFCPoints().execute();

        //get the button view
        afbeelding = (ImageView) rootView.findViewById(R.id.imageView);
        //set a onclick listener for when the button gets clicked
        afbeelding.setOnClickListener(new View.OnClickListener() {
            //Start new list activity
            public void onClick(View v) {
                showPopup(getActivity());
            }
        });

        map = ((SupportMapFragment) getFragmentManager().findFragmentById(R.id.map)).getMap();

        map.moveCamera( CameraUpdateFactory.newLatLngZoom(new LatLng(52.2, 5.25), 7.0f) );

        return rootView;
    }

    private void showPopup(final Activity context) {
        int popupWidth = 500;
        int popupHeight = 390;

        // Inflate the popup_layout.xml
        LinearLayout viewGroup = (LinearLayout) context.findViewById(R.id.popup);
        LayoutInflater layoutInflater = (LayoutInflater) context
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View layout = layoutInflater.inflate(R.layout.popup_layout, viewGroup);

        // Creating the PopupWindow
        final PopupWindow popup = new PopupWindow(context);
        popup.setContentView(layout);
        popup.setWidth(popupWidth);
        popup.setHeight(popupHeight);
        popup.setFocusable(true);

        // Clear the default translucent background
        popup.setBackgroundDrawable(new BitmapDrawable());

        // Displaying the popup at the specified location, + offsets.
        popup.showAtLocation(layout, Gravity.CENTER, 0, 0);
    }


    private class getNFCPoints extends AsyncTask<Void, Void, Void> {
        @Override
        protected Void doInBackground(Void... arg0) {
            // Creating service handler class instance
            ServiceHandler sh = new ServiceHandler();

            // Making a request to url and getting response
            String jsonStr = sh.makeServiceCall("http://www.geodeals.tk/admin/api/nfc", ServiceHandler.GET);

            if (jsonStr != null) {
                try {
                    JSONArray jsonObj = new JSONArray(jsonStr);

                    // looping through All Contacts
                    for (int i = 0; i < jsonObj.length(); i++) {
                        JSONObject c = jsonObj.getJSONObject(i);

                        String x = c.getString("x");
                        String y = c.getString("y");
                        String naam = c.getString("naam");

                        // tmp hashmap for single nfcPointHM
                        HashMap<String, String> nfcPointHM = new HashMap<String, String>();
//
                        // adding each child node to HashMap key => value
                        nfcPointHM.put("x", x);
                        nfcPointHM.put("y", y);
                        nfcPointHM.put("naam", naam);
//
                        // adding nfcPointHM to nfcPointHM list
                        testList.add(nfcPointHM);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Log.e("ServiceHandler", "Couldn't get any data");
            }

            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            super.onPostExecute(result);

            for (int i = 0; i < testList.size(); i++){
                double latitude = Double.parseDouble(testList.get(i).get("x"));
                double longitude = Double.parseDouble(testList.get(i).get("y"));
                String naam = testList.get(i).get("naam");

                MarkerOptions marker = new MarkerOptions().position(new LatLng(latitude, longitude)).title(naam);
                map.addMarker(marker);
            }
        }
    }
}