package com.example.test.qrcode;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;




public class SplashActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.splash);

		AppController.initialize(getApplicationContext());
		SharedPreference.initialize(getApplicationContext());
        new Handler().postDelayed(new Runnable() {
			@Override
			public void run() {
				Intent i = new Intent(SplashActivity.this, MainActivity.class);
				startActivity(i);
				finish();
			}
		}, 3000);
    }


}
