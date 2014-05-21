import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

public class QueryHandler {

	private Connection databaseConnection;

	ArrayList<String> result = new ArrayList<String>();

	QueryHandler(Connection conn) {
		databaseConnection = conn;
	}

	// SQL query, INSERT "values" into "columns" in "table"
	public void doInsert(String values, String columns, String table) {

		try {
			Statement st = databaseConnection.createStatement();
			st.executeUpdate("INSERT INTO " + table + " (" + columns + ") "
					+ "VALUES (" + values + ")");
		} catch (SQLException ex) {
			System.err.println(ex.getMessage());
		}
	}

	// SQL query, SELECT "column" from "table"
	public ArrayList<String> doSelect(String column, String table) {
		String query = "SELECT " + column + " FROM " + table + " ORDER BY id";

		try {
			Statement st = databaseConnection.createStatement();
			ResultSet rs = st.executeQuery(query);
			while (rs.next()) {
				String str = rs.getString(column.toString());
				result.add(str);
			}

			st.close();
			rs.close();
		} catch (SQLException ex) {
			System.err.println(ex.getMessage());
		}

		return result;
	}
	
	public void doUpdate(String values, String columns, String table) {

		try {
			Statement st = databaseConnection.createStatement();
			st.executeUpdate("UPDATE IN " + table + " (" + columns + ") "
					+ "VALUES (" + values + ")");
		} catch (SQLException ex) {
			System.err.println(ex.getMessage());
		}
	}


}