package com.team5.stocksim;

import java.util.ArrayList;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;

public class Login extends Activity
{
	Button loginButton;
	Button registerButton;
	private EditText usernameEditText;
	private EditText passwordEditText;
	private EditText newUsernameEditText;
	private EditText newPasswordEditText;
	private TextView confirmLoginTextView;
	private TextView confirmRegTextView;
	
	private String userName;
	Utility mUtil = new Utility(this); // Utility class for shared functions
	
	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);
		confirmLoginTextView = (TextView) findViewById(R.id.confirmLoginTextView);
		confirmRegTextView = (TextView) findViewById(R.id.confirmRegTextView);
		usernameEditText = (EditText) findViewById(R.id.usernameEditText);
		passwordEditText = (EditText) findViewById(R.id.passwordEditText);
		newUsernameEditText = (EditText) findViewById(R.id.newUsernameEditText);
		newPasswordEditText = (EditText) findViewById(R.id.newPasswordEditText);
		
		loginButton = (Button) findViewById(R.id.loginButton);
		loginButton.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				loginRegister("login");
			}
		});
		registerButton = (Button) findViewById(R.id.registerButton);
		registerButton.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				loginRegister("register");
			}
		});
	}

	public void loginRegister(String task)
	{
		if (mUtil.isNetworkAvailable())
		{
			loginTask mloginTask = new loginTask(Login.this, task);
			mloginTask.execute("");
			loginButton.setEnabled(false);
		}
		else
		{
			Toast.makeText(this,  "Network is not available", Toast.LENGTH_LONG).show();
		}
	}
	
	public class loginTask extends AsyncTask<String, Void, Boolean>
	{

		Context mContext = null;
		String mTask = "";
		String nameToLogin = usernameEditText.getText().toString();
		String pwordToLogin = passwordEditText.getText().toString();
		String nameToRegister = newUsernameEditText.getText().toString();
		String pwordToRegister = newPasswordEditText.getText().toString();
				
		//Result data
		String message;
		int success = 0;
		
		Exception exception = null;
		
		loginTask(Context context, String taskToDo){
				mContext = context;
				mTask = taskToDo;
		}

		@Override
		protected Boolean doInBackground(String... arg0) 
		{

			try
			{
				//Setup the parameters
				ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(3);
				nameValuePairs.add(new BasicNameValuePair("task", mTask));
				if (mTask == "login")
				{
					nameValuePairs.add(new BasicNameValuePair("username", nameToLogin));
					nameValuePairs.add(new BasicNameValuePair("password", pwordToLogin));
				}
				else if (mTask == "register")
				{
					nameValuePairs.add(new BasicNameValuePair("username", nameToRegister));
					nameValuePairs.add(new BasicNameValuePair("password", pwordToRegister));
				}

				//Create the HTTP request
				HttpParams httpParameters = new BasicHttpParams();

				//Setup timeouts
				HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
				HttpConnectionParams.setSoTimeout(httpParameters, 15000);

				HttpClient httpclient = new DefaultHttpClient(httpParameters);
				HttpPost httppost = new HttpPost("http://www.vtklinowsky.com/login.php");
				httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
				HttpResponse response = httpclient.execute(httppost);
				HttpEntity entity = response.getEntity();

				String result = EntityUtils.toString(entity);
				
				// Create a JSON object from the request response
				JSONObject jsonObject = new JSONObject(result);
				
				//Retrieve the data from the JSON object
				success = jsonObject.getInt("success");
				message = jsonObject.getString("message");
				
				
			}catch (Exception e){
				Log.e("ClientServerDemo", "Error:", e);
				exception = e;
			}

			return true;
		}

		@Override
		protected void onPostExecute(Boolean valid)
		{
			//Update the UI
			if (mTask == "login")
			{
				userName = nameToLogin;
				confirmLoginTextView.setText(message);
				loginButton.setEnabled(true);
			}
			else if (mTask == "register")
			{
				userName = nameToRegister;
				confirmRegTextView.setText(message);
				registerButton.setEnabled(true);
			}
			if (success == 1)
			{
				SharedPreferences prefs = getSharedPreferences("MyApp", MODE_PRIVATE);
				prefs.edit().putString("username", userName).commit();
				
				Intent intent = new Intent(Login.this, MainActivity.class);
				intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
				startActivity(intent);
			}		
			if(exception != null){
				Toast.makeText(mContext, exception.getMessage(), Toast.LENGTH_LONG).show();
			}
		}
	}
	
}
