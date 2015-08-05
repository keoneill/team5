package com.team5.stocksim;

import android.app.Activity; // base class for activities
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.AsyncTask; // enables app to run task in the background
import android.os.Bundle;
import android.util.Log; // for exception reporting
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText; // for input
import android.widget.TextView; // for displaying text
import android.widget.Toast; // used for displaying pop up messages
import android.widget.Spinner;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection; 
import java.net.URL;
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


public class MainActivity extends Activity { //ActionBarActivity {

	Utility mUtil = new Utility(this); // Utility class for shared functions
	private TextView displayTickerTextView; // shows Ticker symbol for stock next to Quote
	private TextView displayCompanyTextView;
	private TextView displayQuoteTextView; // shows Price Quote for stock
	private TextView displayConfirmationTextView;
	//private TextView displaySelectionTextView;
	private TextView displayWelcomeTextView;
	private Button getQuoteButton;
	private Button confirmPlayButton;
	private boolean isDowGameClicked = false;
	private String username = "";
	private String tickerSymbol = ""; 	// captured ticker symbol --sent to displayTickerTextView
	private String companyName = "";
	private String priceChange = "";
	private String priceChangePercent = "";
	private String afterHours = "false";
	private String dowGameChoice = "";
	private String[] tickers = { "AAPL", "AXP", "BA", "CAT", "CSCO",
			"CVX", "DD", "DIS", "GE", "GS", 
			"HD", "IBM", "INTC", "JNJ", "JPM",
			"KO", "MCD", "MMM", "MRK", "MSFT",
			"NKE", "PFE", "PG", "TRV", "UNH",
			"UTX", "V", "VZ", "WMT", "XOM"};
	private String[] companies = { "AAPL  --  Apple Inc", "AXP   --  American Express Company",
			"BA    --  The Boeing Company", 	"CAT   --  Caterpillar Inc.", 
			"CSCO  --  Cisco Systems, Inc.", "CVX   --  Chevron Corporation", 
			"DD    --  E.I. du Pont de Nemours and Company", "DIS   --  The Walt Disney Company", 
			"GE    --  General Electric Company", "GS    --  The Goldman Sachs Group, Inc.", 
			"HD    --  The Home Depot, Inc.", "IBM   --  International Business Machines Corporation", 
			"INTC  --  Intel Corporation", "JNJ   --  Johnson & Johnson", 
			"JPM   --  JPMorgan Chase & Co.", "KO    --  The Coca-Cola Company",
			"MCD   --  McDonald’s Corp.", "MMM   --  3M Company", "MRK   --  Merck & Co., Inc.", 
			"MSFT  --  Microsoft Corporation", "NKE   --  Nike, Inc.", "PFE   --  Pfizer Inc.", 
			"PG    --  The Procter & Gamble Company", "TRV   --  The Traveler’s Companies, Inc.",
			"UNH   --  UnitedHealth Group Incorporated", "UTX   --  United Technologies Corporation", 
			"V     --  Visa Inc.", "VZ    --  Verizon Communications Inc.", 
			"WMT   --  Wal-Mart Stores Inc.", "XOM   --  Exxon Mobil Corporation"};

	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		
		displayWelcomeTextView = (TextView) findViewById(R.id.displayWelcomeTextView);
		displayTickerTextView = (TextView) findViewById(R.id.displayTickerTextView);
		displayCompanyTextView = (TextView) findViewById(R.id.displayCompanyTextView);
		displayQuoteTextView = (TextView) findViewById(R.id.displayQuoteTextView);
		displayConfirmationTextView = (TextView) findViewById(R.id.displayConfirmationTextView);
		//displaySelectionTextView = (TextView) findViewById(R.id.displaySelectionTextView);
		
		getActionBar().setHomeButtonEnabled(true);
		
		SharedPreferences prefs = getSharedPreferences("MyApp", MODE_PRIVATE);
		username = prefs.getString("username", "");
		displayWelcome(username);
		
		getQuoteButton = (Button) findViewById(R.id.getQuoteButton);
		getQuoteButton.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				isDowGameClicked = false;
				getQuote(""); // send empty string so getQuote() gets ticker from getTickerEditText
			}
		});
		confirmPlayButton = (Button) findViewById(R.id.confirmPlayButton);
		confirmPlayButton.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				isDowGameClicked = true;
				getQuote(dowGameChoice);
			}
		});
		
		Spinner spinner = (Spinner) findViewById(R.id.dowGameSpinner);
		ArrayAdapter<String> adapter = new ArrayAdapter<String>(this, 
				android.R.layout.simple_spinner_dropdown_item, companies);
		
		spinner.setAdapter(adapter);
		spinner.setOnItemSelectedListener(new OnItemSelectedListener() 
		{
			@Override
			public void onItemSelected(AdapterView<?> arg0, View arg1, int position, long arg3) 
			{
				Toast.makeText(MainActivity.this, 
						"Item selected: " + tickers[position],
							Toast.LENGTH_SHORT).show();
				dowGameChoice = tickers[position];
				//displaySelectionTextView.setText(dowGameChoice);
			}
			@Override
			public void onNothingSelected(AdapterView<?> arg0)
			{
				// TODO Auto-generated method stub
			}
		});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.

		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.

		switch (item.getItemId()){
		case R.id.action_login:
			launchLogin();
			return true;
		case R.id.action_settings:
			Toast.makeText(this, "Settings item clicked", Toast.LENGTH_SHORT).show();
			return true;
		case android.R.id.home:
			Toast.makeText(this, "Home/ Logo clicked", Toast.LENGTH_SHORT).show();
			Intent intent = new Intent(this, MainActivity.class);
			intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(intent);
			return true;
		}
		return super.onOptionsItemSelected(item);
	}	
		
// getQuote function is called when getQuoteButton is pushed
	public void getQuote(String dowGameTicker)
	{
		//trying something else for displaying ticker symbol and company name
		if (dowGameTicker == "")
		{
			EditText getTickerEditText = (EditText) findViewById(R.id.getTickerEditText);
			tickerSymbol = getTickerEditText.getText().toString();
			displayTickerTextView.setText(tickerSymbol);
		}
		else
		{
			tickerSymbol = dowGameTicker;
			displayTickerTextView.setText(tickerSymbol);
		}

		String urlStr = "https://www.google.com/finance?q=" + tickerSymbol; 
		if (mUtil.isNetworkAvailable())
		{
			new ReadStreamTask().execute(urlStr);
		}
		else
		{
			Toast.makeText(this,  "Network is not available", Toast.LENGTH_LONG).show();
		}
	}

	private String readStream(String urlStr) throws IOException
	{
		String str = "";
		InputStream inputStream = null;
		BufferedReader reader = null;
		URL url = new URL(urlStr);
		HttpURLConnection urlConnection = (HttpURLConnection) url.openConnection();
		
		try 
		{
			inputStream = urlConnection.getInputStream();
			reader = new BufferedReader(new InputStreamReader(inputStream));
			
			String line = "";

			// while loop for parsing text for quote
	        while ((line = reader.readLine()) != null) 
	        {
	        	
	        	// search for price
	        	if (line.contains("<meta itemprop=\"name\""))
		       	{
		       		companyName = reader.readLine().trim();
		       	}
	        	else if (line.contains("<meta itemprop=\"price\""))
	        	{
	        		str = trimName(reader.readLine().trim());
	        	}
	        	else if (line.contains("<meta itemprop=\"priceChange\""))
		       	{
		       		priceChange = reader.readLine().trim(); 
		       	}
	        	else if (line.contains("<meta itemprop=\"priceChangePercent\""))
		       	{
		       		priceChangePercent = reader.readLine().trim();
		       	}
	        	else if (line.contains("<meta itemprop=\"isAfterHours\"")
	        			|| line.contains("<meta itemprop=\"isPreMarket\""))
	        	{
	        		afterHours = reader.readLine().trim();
	        	}
	        }
	        if (str == "")
	        {
	        str = "Invalid Ticker";
	        }
		}
		catch (Exception e) 
		{
			Log.d("StockSim", e.toString());
		}
		finally 
		{
			inputStream.close();
			reader.close();
			urlConnection.disconnect();
		}
		return str;
	}
	
	private class ReadStreamTask extends AsyncTask<String, Void, String> 
	{
		String str = "";
		
		@Override
		protected String doInBackground(String... params) 
		{
			try 
			{
				str = readStream(params[0]);
			}
			catch (Exception e) 
			{
				Log.d("StockSim", e.toString());
			}
			return str;
		}
		@Override
		protected void onPostExecute(String result) 
		{
			// display price quote string in displayQuoteTextView
			if (str == "Invalid Ticker")
			{
				displayQuoteTextView.setTextColor(Color.RED);
				displayQuoteTextView.setText(str);
				displayCompanyTextView.setText("");
			}
			else if (result != null)
			{
				try //if (priceChange == "" || priceChangePercent == "")
				{
					String priceChangeDisplay = trimName(priceChange);
					if (priceChangeDisplay.charAt(0) == '+')
					{
						displayQuoteTextView.setTextColor(Color.GREEN);
					}	
					else if (priceChangeDisplay.charAt(0) == '-')
					{
						displayQuoteTextView.setTextColor(Color.RED);
					}	
					displayQuoteTextView.setText(str + "    " + 
						priceChangeDisplay + "    " + trimName(priceChangePercent) + " %");
					displayCompanyTextView.setText(trimName(companyName));
					
					afterHours = trimName(afterHours);
					if (isDowGameClicked)
					{
						if (afterHours.equals("true"))
						{
							playDowGame();
						}
						else 
						{
							displayConfirmationTextView.setText(username + ", the market is currently open, "
									+ "please wait until market closes to make next selection");
						}
					}

				}
				catch(Exception e) 
				{
					displayQuoteTextView.setText("Error");
					displayCompanyTextView.setText("");
					Log.d("StockSim", e.toString());
				}
				// reset variables for next quote 
				companyName = "";
				priceChange = "";
				priceChangePercent = "";
				afterHours = "false";
			}
			else
			{
				displayQuoteTextView.setText("Can't get Quote");
			}
		}
	}
	
	public void launchLogin()
	{
		Intent intent = new Intent(this, Login.class);
		startActivity(intent);
	}
	
	public void playDowGame()
	{
		displayConfirmationTextView.setText(username + ", You've selected " + dowGameChoice);
		doDataTask("updateDowChoice");
	}
	
	public void viewStats(View v)
	{
		doDataTask("viewStats");
	}
	
	public String trimName(String str) // Method that trims meta data to desired string
	{
		char quote = '\"';
   		for (int i = 0; i < str.length(); i++)
   		{
   			if (str.charAt(i) == quote)
   			{
   				for (int j = 1; j < str.length()+i; j++)
   				{
   					if (str.charAt(i+j) == quote)
   					{
   						str = str.substring(i+1, i+j);
   						break;
   					}
   				}
   			}
   		}
		return str;
	}
	private void displayWelcome(String username)
	{
		if (username == "")
		{
			displayWelcomeTextView.setText("Welcome, Guest!");
		}
		else
		{
			displayWelcomeTextView.setText("Welcome, " + username);
		}
	}
	
	public void doDataTask(String task)
	{
		if (mUtil.isNetworkAvailable())
		{
			dataTask mdataTask = new dataTask(MainActivity.this, task);
			mdataTask.execute("");
		}
		else
		{
			Toast.makeText(this,  "Network is not available", Toast.LENGTH_LONG).show();
		}
	}
	
	public class dataTask extends AsyncTask<String, Void, Boolean>
	{

		Context mContext = null;
		String mTask = "";
		String userNameToSearch = username;
				
		//Result data
		String choice;
		String message;
		int success = 0;
		int lastScore;
		double avgScore;
		int numGames;
		int total;
		
		Exception exception = null;
		
		dataTask(Context context, String taskToDo){
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
				if (mTask == "updateDowChoice")
				{
					nameValuePairs.add(new BasicNameValuePair("username", userNameToSearch));
					nameValuePairs.add(new BasicNameValuePair("dowGameChoice", dowGameChoice));
				}
				else if (mTask == "viewStats")
				{
					nameValuePairs.add(new BasicNameValuePair("username", userNameToSearch));
				}

				//Create the HTTP request
				HttpParams httpParameters = new BasicHttpParams();

				//Setup timeouts
				HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
				HttpConnectionParams.setSoTimeout(httpParameters, 15000);

				HttpClient httpclient = new DefaultHttpClient(httpParameters);
				HttpPost httppost = new HttpPost("http://www.vtklinowsky.com/dataTasks.php");
				httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
				HttpResponse response = httpclient.execute(httppost);
				HttpEntity entity = response.getEntity();

				String result = EntityUtils.toString(entity);
				
				// Create a JSON object from the request response
				JSONObject jsonObject = new JSONObject(result);
				
				//Retrieve the data from the JSON object
				
				if (mTask == "updateDowChoice")
				{
					choice = jsonObject.getString("dowGameChoice");
					message = jsonObject.getString("message");
				}
				if (mTask == "viewStats")
				{
					success = jsonObject.getInt("success");
					message = jsonObject.getString("message");
					lastScore = jsonObject.getInt("currentScore");
					avgScore = jsonObject.getDouble("averageScore");					
					numGames = jsonObject.getInt("numGamesPlayed");
					total = jsonObject.getInt("totalScore");
				}

				
				
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
			if (mTask == "updateDowChoice")
			{
				displayConfirmationTextView.setText(message + " " + choice);
			}
			else if (mTask == "viewStats")
			{
				if (success == 1)
				{
					message = "Last Score: " + lastScore + " | Average Score: " + avgScore
							 + " | Games: " + numGames + " | Total Score: " + total;
					displayConfirmationTextView.setText(message);
				}
				else
				{
					displayConfirmationTextView.setText(message);
				}
			}
	
			if(exception != null){
				Toast.makeText(mContext, exception.getMessage(), Toast.LENGTH_LONG).show();
			}
		}
	}
	
}


