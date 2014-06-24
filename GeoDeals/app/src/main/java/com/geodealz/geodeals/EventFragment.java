package com.geodealz.geodeals;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

public class EventFragment extends Fragment {
    public static final String ARG_SECTION_NUMBER = "section_number";
    private ProgressDialog pDialog;
    private ArrayList<HashMap<String, String>> testList;
    {
        testList = new ArrayList<HashMap<String, String>>();
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_evenementen_list, container, false);

        final ListView listview = (ListView) rootView.findViewById(R.id.listview);

        new getDeals().execute();

        listview.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, final View view, int position, long id) {
                Intent intent = new Intent(getActivity(), EventDetailsActivity.class);
                intent.putExtra("naam", testList.get(position).get("naam"));
                intent.putExtra("beschrijving", testList.get(position).get("beschrijving"));
                intent.putExtra("afbeelding", testList.get(position).get("afbeelding"));
                intent.putExtra("user_id", testList.get(position).get("user_id"));
                startActivity(intent);
            }
        });
        return rootView;
    }

    private class StableArrayAdapter extends ArrayAdapter<String> {

        HashMap<String, Integer> mIdMap = new HashMap<String, Integer>();

        public StableArrayAdapter(Context context, int textViewResourceId, List<String> objects) {
            super(context, textViewResourceId, objects);
            for (int i = 0; i < objects.size(); ++i) {
                mIdMap.put(objects.get(i), i);
            }
        }

        @Override
        public long getItemId(int position) {
            String item = getItem(position);
            return mIdMap.get(item);
        }

        @Override
        public boolean hasStableIds() {
            return true;
        }
    }

    private class getDeals extends AsyncTask<Void, Void, Void> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            // Showing progress dialog
            pDialog = new ProgressDialog(getActivity());
            pDialog.setMessage("Bezig met ophalen van deals!");
            pDialog.setCancelable(false);
            pDialog.show();

        }

        @Override
        protected Void doInBackground(Void... arg0) {
            // Creating service handler class instance
            ServiceHandler sh = new ServiceHandler();

            // Making a request to url and getting response
            String jsonStr = sh.makeServiceCall("http://www.geodeals.tk/admin/api/profiel/list", ServiceHandler.GET);

            if (jsonStr != null) {
                try {
                    JSONArray jsonObj = new JSONArray(jsonStr);

                    // looping through All Contacts
                    for (int i = 0; i < jsonObj.length(); i++) {
                        JSONObject c = jsonObj.getJSONObject(i);

                        String naam = c.getString("naam");
                        String afbeelding = c.getString("logo");
                        String beschrijving = c.getString("beschrijving");
                        String user_id = Integer.toString(c.getInt("user_id"));

                        // tmp hashmap for single evenementHM
                        HashMap<String, String> evenementHM = new HashMap<String, String>();

                        // adding each child node to HashMap key => value
                        evenementHM.put("naam", naam);
                        evenementHM.put("afbeelding", afbeelding);
                        evenementHM.put("beschrijving", beschrijving);
                        evenementHM.put("user_id", user_id);

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

            // Dismiss the progress dialog
            if (pDialog.isShowing())
                pDialog.dismiss();

            // Update listview with retrieved data
            final ListView listview = (ListView) getActivity().findViewById(R.id.listview);

            int listSize = testList.size();
            String[] myArray = new String[listSize];
            for (int i = 0; i < listSize; i++) {
                myArray[i] = testList.get(i).get("naam");
            }

            String[] myArray2 = new String[listSize];
            for (int i = 0; i < listSize; i++) {
                myArray2[i] = testList.get(i).get("afbeelding");
            }

            MySimpleArrayAdapter adapter = new MySimpleArrayAdapter(getActivity(), myArray, myArray2, myArray);
            listview.setAdapter(adapter);
        }
    }
}