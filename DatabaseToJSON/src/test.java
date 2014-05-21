import java.sql.SQLException;

public class test {
	public static void main(String args[]) throws SQLException{
		DBConnectorSingleton DBC = DBConnectorSingleton.getInstance("145.24.222.188","8889", "geodeals", "postgres", "GeoDealz");
		DBConnectorSingleton DBC2 = DBConnectorSingleton.getInstance("145.24.222.188","8889", "geodeals", "postgres", "GeoDealz");
	}
}

	