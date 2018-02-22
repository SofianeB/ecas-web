package oph.registrationservice.utils;

import javax.naming.InitialContext;
import javax.naming.NamingException;
import javax.sql.DataSource;

public class DBConnection {

	private final static String DATASOURCE_NAME = "java:/comp/env/jdbc/oph_registration";

	public static DataSource DATASOURCE = null;
	
	static {
		try {
			DATASOURCE = ((DataSource)(new InitialContext()).lookup(DBConnection.DATASOURCE_NAME));
		} catch (NamingException e) {
			e.printStackTrace();
		}
	}
}