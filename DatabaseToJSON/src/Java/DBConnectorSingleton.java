package Java;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.Properties;

public class DBConnectorSingleton {
	private String databaseUrl;
	private Properties props;
	private Connection databaseConn;
	private static DBConnectorSingleton uniqueInstance;

	// set up connection with database
	private DBConnectorSingleton(String host, String port, String dbname,
			String user, String pw) throws SQLException {
		
		try {
		    Class.forName("com.mysql.jdbc.Driver");
		} catch (ClassNotFoundException e) {
		    throw new RuntimeException("Cannot find the driver in the classpath!", e);
		}
		
		databaseUrl = "jdbc:mysql://" + host + ":" + port + "/" + dbname;
		props = new Properties();
		props.setProperty("user", user);
		props.setProperty("password", pw);

		databaseConn = DriverManager.getConnection(databaseUrl, props);

		if (databaseConn != null) {
			System.out.println("Verbinding gemaakt.");
		} else {
			System.out.println("Geen verbinding.");
		}
	}

	// return database connection
	public Connection getDBConn() {
		return databaseConn;
	}

	public static DBConnectorSingleton getInstance(String host, String port,
			String dbname, String user, String pw) throws SQLException {
		if (uniqueInstance == null) {
			uniqueInstance = new DBConnectorSingleton(host, port, dbname, user,
					pw);
		} else {
			// log error
		}
		return uniqueInstance;

	}
	
}
