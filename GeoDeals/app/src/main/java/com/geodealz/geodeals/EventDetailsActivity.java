package com.geodealz.geodeals;

import android.app.ActionBar;
import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.app.ListFragment;
import android.content.Intent;
import android.os.Bundle;
import android.view.Display;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.TextView;

import com.nostra13.universalimageloader.core.ImageLoader;

public class EventDetailsActivity extends Activity {
    String naam = "";
    String beschrijving = "";
    String afbeelding = "";
    String user_id = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.fragment_evenement_details);

        final ActionBar actionBar = getActionBar();

        actionBar.setDisplayHomeAsUpEnabled(true);

        Intent intent = getIntent();
        Bundle extras = intent.getExtras();
        if(extras != null) {
            this.naam = extras.getString("naam");
            this.beschrijving = extras.getString("beschrijving");
            this.afbeelding = extras.getString("afbeelding");
            this.user_id = extras.getString("user_id");
        }

        FragmentManager fm = getFragmentManager();
        FragmentTransaction ft = fm.beginTransaction();
        Fragment frag = new EventDetailsListFragment();

        ft.replace(R.id.deal_fragment, frag);
        ft.commit();

        setTitle(naam);

        ImageView thumbnailView = (ImageView) findViewById(R.id.thumbnail_view);
        TextView messageView = (TextView) findViewById(R.id.message_view);

        ImageLoader imageLoader = ImageLoader.getInstance();
        imageLoader.displayImage("http://www.geodeals.tk/"+afbeelding, thumbnailView);

        Display display = getWindowManager().getDefaultDisplay();
        TextFlowHelper.tryFlowText(beschrijving, thumbnailView, messageView, display, 25);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.action_settings:
                Intent i = new Intent(this, SettingsActivity.class);
                startActivity(i);
                return true;
            case android.R.id.home:
                finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu items for use in the action bar
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.actionbar_actions, menu);
        return super.onCreateOptionsMenu(menu);
    }
}
