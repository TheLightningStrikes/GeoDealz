package com.geodealz.geodeals;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

public class NFCkaartFragment extends Fragment {
    private GoogleMap map;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.fragment_nfckaart, container, false);

        map = ((SupportMapFragment) getFragmentManager().findFragmentById(R.id.map))
                .getMap();

        map.moveCamera( CameraUpdateFactory.newLatLngZoom(new LatLng(52.2, 5.25), 7.0f) );

        // Latitude en longitude
        double latitude = 51.921826;
        double longitude = 4.495811;

        // Maak marker aan
        MarkerOptions marker = new MarkerOptions().position(new LatLng(latitude, longitude)).title("Episch Evenement!");

        // Plaats marker
        map.addMarker(marker);

        return rootView;
    }
}