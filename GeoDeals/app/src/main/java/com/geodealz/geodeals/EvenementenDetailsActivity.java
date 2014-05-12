package com.geodealz.geodeals;

import android.app.ActionBar;
import android.app.Activity;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.app.ListFragment;
import android.content.Intent;
import android.os.Bundle;
import android.view.Display;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.TextView;

public class EvenementenDetailsActivity extends Activity {
    private ImageView image;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.fragment_evenement_details);

        final ActionBar actionBar = getActionBar();
        actionBar.setDisplayHomeAsUpEnabled(true);

        String text = "";
        String title = "";

        Intent intent = getIntent();
        Bundle extras = intent.getExtras();
        if(extras != null) {
            text = extras.getString("data");
            title = extras.getString("title");
        }

        FragmentManager fm = getFragmentManager();
        FragmentTransaction ft = fm.beginTransaction();
        ListFragment frag = new EvenementenDetailsListFragment();
        ft.replace(R.id.evenement_details_fragment, frag);
        ft.commit();

        setTitle(title);

        ImageView thumbnailView = (ImageView) findViewById(R.id.thumbnail_view);
        TextView messageView = (TextView) findViewById(R.id.message_view);

        Display display = getWindowManager().getDefaultDisplay();
        TextFlowHelper.tryFlowText(text, thumbnailView, messageView, display, 25);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}
