package com.geodealz.geodeals;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.nostra13.universalimageloader.core.ImageLoader;

import java.io.IOException;
import java.io.InputStream;
import java.net.URL;

public class MySimpleArrayAdapter extends ArrayAdapter<String> {
    private final Context context;
    private final String[] values;
    private final String[] values2;
    private final String[] values3;

    public MySimpleArrayAdapter(Context context, String[] values, String[] values2, String[] values3) {
        super(context, R.layout.listrow, values);
        this.context = context;
        this.values = values;
        this.values2 = values2;
        this.values3 = values3;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        View rowView = inflater.inflate(R.layout.listrow, parent, false);
        TextView textView = (TextView) rowView.findViewById(R.id.title);
        ImageView imageView = (ImageView) rowView.findViewById(R.id.list_image);
        TextView textView2 = (TextView) rowView.findViewById(R.id.subtitle);

        textView.setText(values[position]);
        textView2.setText(values3[position]);

        if (values2[position] != null) {
            ImageLoader imageLoader = ImageLoader.getInstance();
            imageLoader.displayImage("http://www.geodeals.tk/"+values2[position], imageView);
        }
        else {
            // set default image
        }
        return rowView;
    }
}