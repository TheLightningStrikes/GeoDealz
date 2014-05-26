package Java;

import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.json.simple.JSONObject;

@SuppressWarnings("serial")
@WebServlet("/URLparser")
public class URLparser extends HttpServlet {
	QueryHandler qh; 
	List<String> ParameterArray = new ArrayList<String>();
	List<String> TableArray = new ArrayList<String>();
	List<ArrayList<String>> ArrayLists = new ArrayList<ArrayList<String>>();
	List<QueryHandler> Queries = new ArrayList<QueryHandler>();
	String rest = new String();
	String table = new String();
	
	
	public void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
		ParameterArray.clear();
		TableArray.clear();		
		setQuery(request);
		try {
			selectQuery(table, rest);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		createJSON();
		
	}
	
	public void setQuery(HttpServletRequest request) throws IOException {
		for (int i = 1; i < 10; i++) {
			String param=request.getParameter("column"+i);
			if (param != null) {
				ParameterArray.add(param);
			}
		}	
		
		for (int i = 1; i < 10; i++) {
			String tb=request.getParameter("table"+i);
			if (tb != null) {
				TableArray.add(tb);
			}
		}	
		
		rest = request.getParameter("rest");
			
		for (int i = 1; i < TableArray.size()+1; i++) {
			while (i > 1) {
				table += ", ";
			}
			table += TableArray.get(i-1);
		}
		
		table = table + " ";

	}
	
	public void selectQuery(String table, String rest) throws SQLException, IOException  {
		DBConnectorSingleton DBC = DBConnectorSingleton.getInstance("-","-", "-", "-", "-");
		ArrayLists.clear();

		for (int i = 1; i < ParameterArray.size()+1; i++) {
			Queries.add(new QueryHandler(DBC.getDBConn(), ParameterArray.get(i-1), table, rest));
			ArrayLists.add(Queries.get(i-1).result);
		}
		
	}

	public void createJSON() throws IOException {
		int size = 0;
		FileWriter file = new FileWriter("c:\\test.json");
		
		if (!ArrayLists.isEmpty() && !ParameterArray.isEmpty()) {
			size = ArrayLists.get(0).size();
		}
		
		else {
			size = 0;
		}
		
		for (int i = 1; i < size+1; i++) {
			JSONObject obj = new JSONObject();
			JSONObject title = new JSONObject();
			for (int j = 1; j < ParameterArray.size()+1; j++) {
				obj.put(ParameterArray.get(j-1), ArrayLists.get(j-1).get(i-1));
			}
			title.put("result "+i, obj);
			file.write(title.toJSONString()+" \r\n");
		}
		file.flush();
		file.close();

	}

}

