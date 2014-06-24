package com.geodealz.geodeals;

import android.app.ActionBar;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.CompoundButton;
import android.widget.Switch;

public class SettingsActivity extends Activity {
    private Switch mySwitch;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_settings);

        final ActionBar actionBar = getActionBar();
        actionBar.setDisplayHomeAsUpEnabled(true);

        final SharedPreferences prefs = this.getSharedPreferences("com.geodealz.geodeals", Context.MODE_PRIVATE);
        final String key = "com.geodealz.geodeals.locationChecked";

        boolean locationEnabled = prefs.getBoolean(key, true);

        mySwitch = (Switch) findViewById(R.id.switch1);
        //set the switch to ON
        mySwitch.setChecked(locationEnabled);
        //attach a listener to check for changes in state
        mySwitch.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if(isChecked){
                    Log.d("CHECKED", "JA");
                    prefs.edit().putBoolean(key, true).commit();
                }else{
                    Log.d("CHECKED", "NEE");
                    prefs.edit().putBoolean(key, false).commit();
                }
            }
        });
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                return true;
            case R.id.action_about:
                Intent i = new Intent(this, AboutGeoDealsActivity.class);
                startActivity(i);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu items for use in the action bar
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.actionbar_actions_settings, menu);
        return super.onCreateOptionsMenu(menu);
    }
}
