package Java;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

public class QueryHandler {

	private Connection databaseConnection;

	ArrayList<String> result = new ArrayList<String>();

	QueryHandler(Connection conn, String column, String table, String rest) {
		databaseConnection = conn;
		result = doSelect(column, table, rest);
	}



	// SQL query, SELECT "column" from "table"
	public ArrayList<String> doSelect(String column, String table, String rest) {
		String query = "SELECT " + column + " FROM " + table + rest;
		result.clear();

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
	

}