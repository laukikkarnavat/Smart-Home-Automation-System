package com.example.laukik.awsmobileapp;

        import android.support.v7.app.AppCompatActivity;
        import android.os.Bundle;
        import android.util.Log;
        import android.widget.TextView;

        import org.json.JSONObject;

        import okhttp3.MediaType;
        import okhttp3.OkHttpClient;
        import okhttp3.Request;
        import okhttp3.RequestBody;
        import okhttp3.Response;

public class RetrievedData extends AppCompatActivity {
    TextView retrievedData;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_retrieved_data);

        retrievedData=(TextView)findViewById(R.id.retrievedText);
        retrievedData.setText(MainActivity.retrievedData);
    }
}