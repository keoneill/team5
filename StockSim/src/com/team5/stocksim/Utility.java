package com.team5.stocksim;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;



public class Utility 
{
	Context mContext;
	public Utility(Context mContext)
	{
		this.mContext = mContext;
	}
	
	public boolean isNetworkAvailable()
	{
		boolean available = false;
		
		ConnectivityManager manager = (ConnectivityManager) 
				mContext.getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo networkInfo = manager.getActiveNetworkInfo();
		if (networkInfo != null && networkInfo.isAvailable())
		{
			available = true;
		}
		return available;
	}
}
