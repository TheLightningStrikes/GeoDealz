package com.geodealz.geodeals;


import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.app.ListFragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;

public class EvenementenDetailsListFragment extends ListFragment {

    String[] rows = new String[] { "Actie 1", "Actie 2", "Actie 3",
            "Actie 4", "Actie 5", "Actie 6", "Actie 7", "Actie 8",
            "Actie 9", "Actie 10", "Actie 11", "Actie 12", "Actie 13",
            "Actie 14", "Actie 15", "Actie 16", "Actie 17", "Actie 18",
            "Actie 19", "Actie 20"};

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,Bundle savedInstanceState) {
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(inflater.getContext(), android.R.layout.simple_list_item_1,rows);
        setListAdapter(adapter);

        return super.onCreateView(inflater, container, savedInstanceState);
    }

    @Override
    public void onListItemClick(ListView l, View v, int position, long id) {
        FragmentManager fm = getFragmentManager();
        FragmentTransaction ft = fm.beginTransaction();

        ListFragment frag = new EvenementenDetailsListFragment();

        ft.remove(fm.findFragmentById(R.id.evenement_details_fragment));
        ft.replace(R.id.evenement_details_fragment, frag);

        ft.addToBackStack(null);
        ft.commit();
    }
}