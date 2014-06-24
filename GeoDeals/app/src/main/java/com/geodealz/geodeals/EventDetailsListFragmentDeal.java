package com.geodealz.geodeals;

import android.app.AlertDialog;
import android.app.Dialog;
import android.app.Fragment;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.Settings;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.RatingBar;
import android.widget.TextView;

import com.nostra13.universalimageloader.core.ImageLoader;

import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;

import java.io.IOException;

public class EventDetailsListFragmentDeal extends Fragment {
    String deal_id = "";
    private RatingBar ratingBar;
    int ratingValue;
    String key = "";
    SharedPreferences prefs;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_evenementen_details_acties, container, false);
    }

    @Override
    public void onResume() {
        super.onResume();
        Bundle args = getArguments();

        ratingBar = (RatingBar) getView().findViewById(R.id.ratingBar);
        ratingBar.setOnRatingBarChangeListener(new RatingBar.OnRatingBarChangeListener() {
            public void onRatingChanged(RatingBar ratingBar, float rating,boolean fromUser) {
                ratingValue = (int) rating;
            }
        });

        if (args.getString("deal_id")!=null) {
            this.deal_id = args.getString("deal_id");
        }

        TextView textView = (TextView) getView().findViewById(R.id.acties_text);
        textView.setText(args.getString("bedrijf"));

        TextView textView2 = (TextView) getView().findViewById(R.id.omschrijving);
        textView2.setText(args.getString("omschrijving"));

        if (args.getString("amount_left")!=null) {
            TextView special_deal_textView = (TextView) getView().findViewById(R.id.special_deals);
            special_deal_textView.setText("Deals over: " + args.getString("amount_left"));
            Button activatedeal_button = (Button) getView().findViewById(R.id.activatedeal_button);
            activatedeal_button.setVisibility(View.VISIBLE);
            activatedeal_button.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    key = "com.geodealz.geodeals.dealActivated." + deal_id;
                    prefs = getActivity().getSharedPreferences("com.geodealz.geodeals", Context.MODE_PRIVATE);
                    Boolean alreadyused = prefs.getBoolean(key, false);

                    if (!alreadyused) {
                        confirmUseDeal();
                    }
                    else {
                        dealAlreadyUsed();
                    }
                }
            });
        }

        Button stem_button = (Button) getView().findViewById(R.id.stem_button);
        stem_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                key = "com.geodealz.geodeals.dealVoted." + deal_id;
                prefs = getActivity().getSharedPreferences("com.geodealz.geodeals", Context.MODE_PRIVATE);
                Boolean alreadyVoted = prefs.getBoolean(key, false);

                if (!alreadyVoted) {
                    confirmVote();
                }
                else {
                    alreadyVoted();
                }
            }
        });

        if (args.getString("startdatum")!=null) {
            TextView special_deal_textView = (TextView) getView().findViewById(R.id.special_deals);
            special_deal_textView.setPadding(0, 18, 16, 0);
            special_deal_textView.setText("Geldig van: " + args.getString("startdatum") + "\n" +
                    "               tot " + args.getString("einddatum"));
        }

        ImageView image = (ImageView) getView().findViewById(R.id.imageView);
        ImageLoader imageLoader = ImageLoader.getInstance();
        imageLoader.displayImage("http://www.geodeals.tk/"+args.getString("afbeelding"), image);
    }

    private class usedDeal extends AsyncTask<Void, Void, Void> {

        private final HttpClient Client = new DefaultHttpClient();
        private String Content;
        private String Error = null;
        private String url = "http://www.geodeals.tk/admin/api/deals/used/"+deal_id+"/pepdebwilboy";

        // Call after onPreExecute method
        protected Void doInBackground(Void... arg0) {
            try {
                HttpGet httpget = new HttpGet(url);
                ResponseHandler<String> responseHandler = new BasicResponseHandler();
                Content = Client.execute(httpget, responseHandler);
            } catch (ClientProtocolException e) {
                Error = e.getMessage();
                cancel(true);
            } catch (IOException e) {
                Error = e.getMessage();
                cancel(true);
            }
            return null;
        }
        protected void onPostExecute(Void unused) {
            if (Error != null) {
            } else {
            }
        }
    }

    private class sendRating extends AsyncTask<Void, Void, Void> {

        private final HttpClient Client = new DefaultHttpClient();
        private String Content;
        private String Error = null;
        private String url = "http://www.geodeals.tk/admin/api/deals/rate/"+ratingValue+"/"+deal_id;

        // Call after onPreExecute method
        protected Void doInBackground(Void... arg0) {
            try {
                HttpGet httpget = new HttpGet(url);
                ResponseHandler<String> responseHandler = new BasicResponseHandler();
                Content = Client.execute(httpget, responseHandler);
            } catch (ClientProtocolException e) {
                Error = e.getMessage();
                cancel(true);
            } catch (IOException e) {
                Error = e.getMessage();
                cancel(true);
            }
            return null;
        }
        protected void onPostExecute(Void unused) {
            if (Error != null) {
            } else {
            }
        }
    }

    private void confirmVote(){
        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(getActivity());
        alertDialogBuilder.setMessage("Weet u zeker dat u uw stem definitief wilt maken?")
                .setCancelable(true)
                .setPositiveButton("Ja",
                        new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                new sendRating().execute();
                                prefs.edit().putBoolean(key, true).commit();
                            }
                        }
                );
        alertDialogBuilder.setNegativeButton("Nee",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                    }
                });
        AlertDialog alert = alertDialogBuilder.create();
        alert.show();
    }

    private void alreadyVoted(){
        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(getActivity());
        alertDialogBuilder.setMessage("U heeft al gestemd. U mag slechts eenmaal stemmen.")
                .setCancelable(true);
        alertDialogBuilder.setNegativeButton("Sluiten",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                    }
                });
        AlertDialog alert = alertDialogBuilder.create();
        alert.show();
    }

    private void confirmUseDeal(){
        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(getActivity());
        alertDialogBuilder.setMessage("Weet u zeker dat u deze Deal wilt activeren?")
                .setCancelable(true)
                .setPositiveButton("Ja",
                        new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                new usedDeal().execute();
                                prefs.edit().putBoolean(key, true).commit();
                            }
                        }
                );
        alertDialogBuilder.setNegativeButton("Nee",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                    }
                });
        AlertDialog alert = alertDialogBuilder.create();
        alert.show();
    }

    private void dealAlreadyUsed(){
        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(getActivity());
        alertDialogBuilder.setMessage("U heeft deze Deal gebruikt. U mag elke Deal slechts eenmaal gebruiken.")
                .setCancelable(true);
        alertDialogBuilder.setNegativeButton("Sluiten",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                    }
                });
        AlertDialog alert = alertDialogBuilder.create();
        alert.show();
    }
}