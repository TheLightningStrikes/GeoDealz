package com.geodealz.geodeals;

import android.app.Fragment;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.app.ListFragment;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

public class EventDetailsListFragment extends ListFragment {
    Boolean started = false;
    String user_id = "";
    private ArrayList<HashMap<String, String>> testList;
    {
        testList = new ArrayList<HashMap<String, String>>();
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,Bundle savedInstanceState) {
        if (started != true) {
            Intent intent = getActivity().getIntent();
            Bundle extras = intent.getExtras();
            if (extras != null) {
                this.user_id = extras.getString("user_id");
            }

            testList.clear();
            new getDeals().execute();
            started = true;
        }

        return super.onCreateView(inflater, container, savedInstanceState);
    }

    @Override
    public void onListItemClick(ListView l, View v, int position, long id) {
        FragmentManager fm = getFragmentManager();
        FragmentTransaction ft = fm.beginTransaction();

        Bundle data = new Bundle();

        data.putString("omschrijving", testList.get(position).get("omschrijving"));
        data.putString("bedrijf", testList.get(position).get("bedrijf"));
        data.putString("afbeelding", testList.get(position).get("afbeelding"));
        data.putString("deal_id", testList.get(position).get("deal_id"));
        if (testList.get(position).get("type").equals("limited")) {
            data.putString("amount_left", testList.get(position).get("amountleft"));
        }
        if (testList.get(position).get("type").equals("date")) {
            data.putString("startdatum", testList.get(position).get("startdatum"));
            data.putString("einddatum", testList.get(position).get("einddatum"));
        }

        Fragment frag = new EventDetailsListFragmentDeal();

        frag.setArguments(data);

        ft.remove(fm.findFragmentById(R.id.deal_fragment));
        ft.replace(R.id.deal_fragment, frag);

        ft.addToBackStack(null);
        ft.commit();
    }


    private class getDeals extends AsyncTask<Void, Void, Void> {
        @Override
        protected Void doInBackground(Void... arg0) {
            // Creating service handler class instance
            ServiceHandler sh = new ServiceHandler();

            // Making a request to url and getting response
            String jsonStr = sh.makeServiceCall("http://www.geodeals.tk/admin/api/deals/evenement/"+user_id, ServiceHandler.GET);

            if (jsonStr != null) {
                try {
                    JSONArray jsonObj = new JSONArray(jsonStr);

                    // looping through All Contacts
                    for (int i = 0; i < jsonObj.length(); i++) {
                        JSONObject c = jsonObj.getJSONObject(i);

                        String naam = c.getString("naam");
                        String afbeelding = c.getString("deal");
                        String omschrijving = c.getString("omschrijving");
                        String bedrijf = c.getString("bedrijf");
                        String type = c.getString("type");
                        String deal_id = "";
                        if (type.equals("normal")) {
                            deal_id = c.getString("id");
                        }
                        else {
                            deal_id = c.getString("deal_id");
                        }
                        String amountleft = "";
                        if (type.equals("limited")) {
                            amountleft = c.getString("amountleft");
                        }
                        String startdatum = "";
                        String einddatum = "";
                        if (type.equals("date")) {
                            startdatum = c.getString("startdatum");
                            einddatum = c.getString("einddatum");
                        }


                        // tmp hashmap for single evenementHM
                        HashMap<String, String> evenementHM = new HashMap<String, String>();
//
                        // adding each child node to HashMap key => value
                        evenementHM.put("naam", naam);
                        evenementHM.put("afbeelding", afbeelding);
                        evenementHM.put("omschrijving", omschrijving);
                        evenementHM.put("bedrijf", bedrijf);
                        evenementHM.put("type", type);
                        evenementHM.put("deal_id", deal_id);
                        if (type.equals("limited")) {
                            evenementHM.put("amountleft", amountleft);
                        }
                        if (type.equals("date")) {
                            evenementHM.put("startdatum", startdatum);
                            evenementHM.put("einddatum", einddatum);
                        }
//
                        // adding evenementHM to evenementHM list
                        testList.add(evenementHM);
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

            int listSize = testList.size();
            String[] myArray = new String[listSize];
            for (int i = 0; i < listSize; i++) {
                myArray[i] = testList.get(i).get("naam");
            }

            String[] myArray2 = new String[listSize];
            for (int i = 0; i < listSize; i++) {
                myArray2[i] = testList.get(i).get("afbeelding");
            }

            String[] myArray3 = new String[listSize];
            for (int i = 0; i < listSize; i++) {
                myArray3[i] = testList.get(i).get("bedrijf");
            }

            MySimpleArrayAdapter adapter2 = new MySimpleArrayAdapter(getActivity(), myArray, myArray2, myArray3);
            setListAdapter(adapter2);
        }
    }
}