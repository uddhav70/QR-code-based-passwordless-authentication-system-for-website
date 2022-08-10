package com.example.test.qrcode;


import android.content.Intent;
import android.os.Bundle;
import android.provider.Settings;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity implements View.OnClickListener {
    String android_id;
    String s = "";
    //View Objects
    private Button buttonScan;
    private TextView qrcodedata;
    //qr code scanner object
    private IntentIntegrator qrScan;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Log.i("prefre", SharedPreference.contains("keydata") + "");
        if (SharedPreference.contains("keydata")) {
            Log.i("true", SharedPreference.get("keydata"));
        }else{
            //Log.i("false", SharedPreference.get("keydata"));
        }
        android_id = Settings.Secure.getString(getApplicationContext().getContentResolver(), Settings.Secure.ANDROID_ID);
        Toast.makeText(this, android_id, Toast.LENGTH_SHORT).show();
        Log.d("s", Keys.URL.LOGIN_URL);
        //View objects
        buttonScan = (Button) findViewById(R.id.buttonScan);

        qrcodedata = (TextView) findViewById(R.id.qrcodedata);

        //intializing scan object
        qrScan = new IntentIntegrator(this);
        SharedPreference.save("keydata", "data");
        //attaching onclick listener
        buttonScan.setOnClickListener(this);
    }

    //Getting the scan results
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        IntentResult result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        if (result != null) {
            //if qrcode has nothing in it
            if (result.getContents() == null) {
                //SharedPreference.save("keydata", "cancel");
                Toast.makeText(this, "Result Not Found", Toast.LENGTH_LONG).show();
            } else {
                if (SharedPreference.contains("keydata")) {
                    Olduser(result.getContents());
                   // Toast.makeText(this, "New", Toast.LENGTH_SHORT).show();
                }
                NewLogin(result.getContents());

               /* if(SharedPreference.contains("keydata")){
                    Toast.makeText(this, "Yes", Toast.LENGTH_SHORT).show();
                    NewLogin(result.getContents());
                }else{
                    Toast.makeText(this, "No", Toast.LENGTH_SHORT).show();
                    Olduser(result.getContents());
                }*/

                //qrcodedata.setText(result.getContents());
                //Toast.makeText(this, result.getContents(), Toast.LENGTH_LONG).show();

            }
        } else {
            super.onActivityResult(requestCode, resultCode, data);
        }
    }

    @Override
    public void onClick(View view) {
        //initiating the qr code scan
        qrScan.initiateScan();
    }

    public void NewLogin(final String keydata) {
        // pBar.setVisibility(View.VISIBLE);

        //  String web = "http://localhost/qrlogin/php/functions.php";
        Log.d("s", Keys.URL.LOGIN_URL);
        StringRequest request = new StringRequest(Request.Method.POST, Keys.URL.LOGIN_URL, new Response.Listener<String>() {
            //StringRequest request = new StringRequest(Method.POST, Keys.URL.LOGIN_URL, new Listener<String>() {
            @Override
            public void onResponse(String arg0) {
                Log.i("new user", arg0);
                SharedPreference.save("keydata", "abc");
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError arg0) {
                //pBar.setVisibility(View.GONE);
                Toast.makeText(getApplicationContext(), "Please check IP addess", Toast.LENGTH_LONG).show();
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();

                params.put("username", keydata);
                params.put("action", "setuniquekey");
                params.put("uniquekey", android_id);
                return params;
            }
        };

        AppController.getInstance().add(request);
    }

    public void Olduser(final String keydata) {
        // pBar.setVisibility(View.VISIBLE);

        //  String web = "http://localhost/qrlogin/php/functions.php";
        //Log.d("s",Keys.URL.LOGIN_URL);
        StringRequest request = new StringRequest(Request.Method.POST, Keys.URL.LOGIN_URL, new Response.Listener<String>() {
            //StringRequest request = new StringRequest(Method.POST, Keys.URL.LOGIN_URL, new Listener<String>() {
            @Override
            public void onResponse(String arg0) {
                Log.i("old user", arg0);

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError arg0) {
                //pBar.setVisibility(View.GONE);
                Toast.makeText(getApplicationContext(), "Please check IP addess", Toast.LENGTH_LONG).show();
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();

                params.put("username", keydata);
                params.put("action", "login");
                params.put("uniquekey", android_id);
                return params;
            }
        };

        AppController.getInstance().add(request);
    }
}