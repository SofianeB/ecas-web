package oph.registrationservice.utils;

public enum SqlQuery {
	
	INSERT_USER("INSERT INTO ophuser (first_name, last_name, email, affiliation, motivation, newsletter) VALUES (?, ?, ?, ?, ?,?);"),
	CHECK_EMAIL("SELECT email FROM ophuser WHERE email=?;");
    
	private final String sql;
	
	SqlQuery(final String sql) {
		this.sql = sql;
	}

	public String getSql() {
		return sql;
	}
	
	@Override
	public String toString() {
		return getSql();
	}
}

