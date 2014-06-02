package com.geodealz.geodeals;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

public class EvenementenDetailsActiesFragment extends Fragment {
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_evenementen_details_acties, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();
        Bundle args = getArguments();

        TextView view = (TextView) getView().findViewById(R.id.acties_text);
        view.setText(args.getString("actietekst"));
    }
}