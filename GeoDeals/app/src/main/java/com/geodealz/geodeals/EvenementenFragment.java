package com.geodealz.geodeals;

import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.app.ListFragment;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

public class EvenementenFragment extends Fragment {

    private ListView mainListView ;
    private ArrayAdapter<String> listAdapter ;
    public static final String ARG_SECTION_NUMBER = "section_number";

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_evenementen_list, container, false);

        final ListView listview = (ListView) rootView.findViewById(R.id.listview);
        String[] values = new String[] { "Evenement 1", "Evenement 2", "Evenement 3",
                "Evenement 4", "Evenement 5", "Evenement 6", "Evenement 7", "Evenement 8",
                "Evenement 9", "Evenement 10", "Evenement 11", "Evenement 12", "Evenement 13",
                "Evenement 14", "Evenement 15", "Evenement 16", "Evenement 17", "Evenement 18",
                "Evenement 19", "Evenement 20"};

        final ArrayList<String> list = new ArrayList<String>();
        for (int i = 0; i < values.length; ++i) {
            list.add(values[i]);
        }

        //MySimpleArrayAdapter adapter = new MySimpleArrayAdapter(getActivity(), values);
        //listview.setAdapter(adapter);

        final StableArrayAdapter adapter = new StableArrayAdapter(getActivity(),android.R.layout.simple_list_item_1, list);
        listview.setAdapter(adapter);

        listview.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, final View view, int position, long id) {
                Intent intent = new Intent(getActivity(), EvenementenDetailsActivity.class);
                switch (position){
                    case 0:
                        intent.putExtra("data", "HOIJDSF KJLFSJDKJKDJ DSJKF KJLDSSJ KDFJKFD SKJLF DKLJF JLKDJ KLSFDJK LFDJSKLJL SDFJ KDSLFKLJS FDKJLFSDKJLSFDJKL");
                        break;
                    default:
                        intent.putExtra("data", "DEFAULT TEXTTT");
                        break;
                }
                Object listItem = listview.getItemAtPosition(position);
                intent.putExtra("title", listItem.toString());
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
}