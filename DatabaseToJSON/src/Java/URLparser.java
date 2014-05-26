package Java;

import java.io.BufferedReader;
import java.io.FileReader;
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

@WebServlet("/URLparser")
public class URLparser extends HttpServlet {
	private static final long serialVersionUID = 1L;
	private QueryHandler qh; 
	private List<String> ParameterArray = new ArrayList<String>();
	private List<String> TableArray = new ArrayList<String>();
	private List<ArrayList<String>> ArrayLists = new ArrayList<ArrayList<String>>();
	private List<QueryHandler> Queries = new ArrayList<QueryHandler>();
	private String rest = new String();
	private String table = new String();
	private String ip = new String();
	private String port = new String();
	private String db = new String();
	private String user = new String();
	private String pw = new String();
	private String directory = "C:\\results.json";
	
	
	public void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
		ParameterArray.clear();
		TableArray.clear();	
		ArrayLists.clear();
		Queries.clear();
		table = "";
		
		setDBtarget();
		setQuery(request);
		try {
			selectQuery(table, rest);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		createJSON();
		
	}
	
	private void setQuery(HttpServletRequest request) throws IOException {
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
		
		if (request.getParameter("rest") != null) {
			rest = request.getParameter("rest");
		}
		else { 
			rest = "";
		}
			
		for (int i = 1; i < TableArray.size()+1; i++) {
			while (i > 1) {
				table += ", ";
			}
			table += TableArray.get(i-1);
		}
		
		table = table + " ";

	}
	
	private void selectQuery(String table, String rest) throws SQLException, IOException  {
		DBConnectorSingleton DBC = DBConnectorSingleton.getInstance(ip, port, db, user, pw);
		ArrayLists.clear();
		System.out.println(ArrayLists.isEmpty()+" HIERO");

		for (int i = 1; i < ParameterArray.size()+1; i++) {
			Queries.add(new QueryHandler(DBC.getDBConn(), ParameterArray.get(i-1), table, rest));
			ArrayLists.add(Queries.get(i-1).result);
		}
		
	}

	private void createJSON() throws IOException {
		int size = 0;
		FileWriter file = new FileWriter(directory);
		
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
			obj.clear();
			title.clear();
		}
		file.flush();
		file.close();

	}
	
	private void setDBtarget() {
		
		try (BufferedReader br = new BufferedReader(new FileReader("C:\\serverdb.txt")))
		{	
			ip = br.readLine(); 
			port = br.readLine();
			db =  br.readLine();
			user =  br.readLine();
			pw =  br.readLine();
 
		} catch (IOException e) {
			e.printStackTrace();
		} 
 
	}

}

