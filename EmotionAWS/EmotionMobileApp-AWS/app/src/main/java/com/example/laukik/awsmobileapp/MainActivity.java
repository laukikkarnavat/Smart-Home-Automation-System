package com.example.laukik.awsmobileapp;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Handler;
import android.provider.Settings;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.text.DateFormat;
import java.time.LocalDateTime;
import java.time.LocalTime;
import java.time.ZoneId;
import java.time.format.DateTimeFormatter;
import java.util.Calendar;
import java.util.Locale;

import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class MainActivity extends AppCompatActivity {

    Geocoder geocoder;
    Button Happy;
    Button Depressed;
    Button Angry;
    Button Jealous;
    Button Indifferent;
    Button Posting;
    Button Retrieve;

    String emotion;
    String Address = "";
    static String retrievedData="";

    private LocationManager locationManager;
    private LocationListener locationListener;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        ZoneId zoneId = ZoneId.of("America/New_York");

        LocalTime localTime=LocalTime.now(zoneId);
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("HH:mm:ss");
        String formattedTime=localTime.format(formatter);

        TextView textViewTime = findViewById(R.id.time);
        textViewTime.setText(formattedTime);

        Calendar calendar= Calendar.getInstance();
        //String currentDate = DateFormat.getDateInstance(DateFormat.SHORT).format(calendar.getTime());
        String currentDate = DateFormat.getDateInstance(DateFormat.SHORT).format(calendar.getTime());

        TextView textViewDate = findViewById(R.id.date);
        textViewDate.setText(currentDate);

        Happy = (Button) findViewById(R.id.Happy);
        Depressed = (Button) findViewById(R.id.Depressed);
        Angry = (Button) findViewById(R.id.Angry);
        Jealous = (Button) findViewById(R.id.Jealous);
        Indifferent = (Button) findViewById(R.id.Indifferent);
        Posting = (Button) findViewById(R.id.Posting);
        Retrieve = (Button) findViewById(R.id.Retrieve);
        geocoder = new Geocoder(this, Locale.getDefault());

        Happy.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                emotion = Happy.getText().toString();
                Toast.makeText(getApplicationContext(), emotion, Toast.LENGTH_SHORT).show();

            }
        });

        Depressed.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                emotion = Depressed.getText().toString();
                Toast.makeText(getApplicationContext(), emotion, Toast.LENGTH_SHORT).show();
            }
        });

        Angry.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                emotion = Angry.getText().toString();
                Toast.makeText(getApplicationContext(), emotion, Toast.LENGTH_SHORT).show();
            }
        });

        Jealous.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                emotion = Jealous.getText().toString();
                Toast.makeText(getApplicationContext(), emotion, Toast.LENGTH_SHORT).show();
            }
        });

        Indifferent.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                emotion = Indifferent.getText().toString();
                Toast.makeText(getApplicationContext(), emotion, Toast.LENGTH_SHORT).show();
            }
        });

        Retrieve.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Toast.makeText(getApplicationContext(), "RETRIEVING", Toast.LENGTH_SHORT).show();
                new Thread(new Runnable() {
                    @Override
                    public void run() {

                        OkHttpClient client = new OkHttpClient();
                        MediaType JSON = MediaType.parse("application/json;charset=utf-8");
                        JSONObject actualObject = new JSONObject();

                        try {
                            actualObject.put("key2", emotion);
                            actualObject.put("selection", "Retrieve");

                        } catch (JSONException e) {
                            Log.i("Error is!!! ", e.toString());
                        }

                        RequestBody body = RequestBody.create(JSON, actualObject.toString());
                        Request newReq = new Request.Builder()
                                .url("https://dl9ax4rs27.execute-api.us-east-1.amazonaws.com/sendingData")
                                .post(body)
                                .build();
                        try {
                            Response response = client.newCall(newReq).execute();
                            retrievedData= response.body().string();
                            Log.i("Retrieved Data is!!! ", retrievedData);

                        } catch (Exception e) {
                            Log.i("Error2 in Retrieving!!! ", e.toString());
                        }
                    }

                }).start();

                Handler handler = new Handler();
                Runnable r =new Runnable() {
                    @Override
                    public void run() {
                        startActivity(new Intent(getBaseContext(), RetrievedData.class));
                    }
                    };
                handler.postDelayed(r, 5000);
            }
        });

        Posting.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Toast.makeText(getApplicationContext(), "POSTING", Toast.LENGTH_SHORT).show();

                new Thread(new Runnable() {
                    @Override
                    public void run() {

                        OkHttpClient client = new OkHttpClient();
                        MediaType JSON = MediaType.parse("application/json;charset=utf-8");
                        JSONObject actualObject = new JSONObject();

                        try {
                            actualObject.put("key1", "Laukik");
                            actualObject.put("key2", emotion);
                            actualObject.put("key3", Address);
                            actualObject.put("key4", LocalDateTime.now().getYear() + "/"
                                    + LocalDateTime.now().getMonth() + "/" + LocalDateTime.now().getDayOfMonth());

                            actualObject.put("key5", LocalDateTime.now().getHour() + ":" + LocalDateTime.now().getMinute());
                            actualObject.put("selection", "Posting" );
                        } catch (JSONException e) {
                            Log.i("Error2 is!!! ", e.toString());
                        }

                        RequestBody body = RequestBody.create(JSON, actualObject.toString());
                        Request newReq = new Request.Builder()
                                .url("https://dl9ax4rs27.execute-api.us-east-1.amazonaws.com/sendingData")
                                .post(body)
                                .build();
                        try {
                            Address = Address.trim();
                            Response response = client.newCall(newReq).execute();
                            Log.i("Response is!!! ", response.toString());
                           /* String pattern = "\\[addressLines=.*\\],";
                            Pattern r = Pattern.compile(pattern);
                            Matcher m = r.matcher(Address.trim());
                            while(m.find())
                            {
                                Address= m.group().trim().replace("[addressLines=","")
                                        .replace(",", "");
                                Log.i("CurrentAddress is!!! ",Address.trim());
                                Response response= client.newCall(newReq).execute();
                                Log.i("Response is!!! ",response.toString());

                            }*/
                        } catch (Exception e) {
                            Toast.makeText(getApplicationContext(), "Error is" + e, Toast.LENGTH_SHORT).show();
                            Log.i("Error!!! ", e.toString());
                        }
                    }

                }).start();
            }
        });


        //locationManager = (LocationManager) this.getSystemService(LOCATION_SERVICE);
        locationManager = (LocationManager) getSystemService(LOCATION_SERVICE);
        locationListener = new LocationListener() {
            @Override
            public void onLocationChanged(Location location) {

                try {


                    Toast.makeText(getBaseContext(),
                            geocoder.getFromLocation(location.getLatitude(), location.getLongitude(), 1).toString(),
                            Toast.LENGTH_SHORT).show();

                    Address = geocoder.getFromLocation(location.getLatitude(), location.getLongitude(), 1).toString();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }

            @Override
            public void onStatusChanged(String provider, int status, Bundle extras) {

            }

            @Override
            public void onProviderEnabled(String provider) {

            }

            @Override
            public void onProviderDisabled(String provider) {
                Intent intent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
                startActivity(intent);
            }
        };

        /*if (Build.VERSION.SDK_INT < 23) {*/

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED)
        {
            ActivityCompat.requestPermissions(this, new String[]{
                    Manifest.permission.ACCESS_FINE_LOCATION, Manifest.permission.ACCESS_COARSE_LOCATION, Manifest.permission.INTERNET
            }, 3);
        } else {

            locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, locationListener);
        }
    }

    public void onRequestPermissionResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);

        if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
            if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                    == PackageManager.PERMISSION_GRANTED
                    && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION)
                    == PackageManager.PERMISSION_GRANTED) {

                locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, locationListener);
            }
        }
    }
}
