package oph.registrationservice.actions.json;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Properties;

import oph.registrationservice.utils.DBConnection;
import oph.registrationservice.utils.SqlQuery;

import com.opensymphony.xwork2.ActionSupport;

import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.*;

public class UserRegistrationAction extends ActionSupport {
	
	private static final long serialVersionUID = -411407898907293802L;
	
	private String first_name;
	private String last_name;
	private String email;
	private String affiliation;
	private String motivation;
	private String newsletter;
	
	private String username;
	private String password;
	private String smtpAuth;
	private String smtpStarttlsEnable;
	private String smtpHost;
	private String smtpPort;
	private String mailDebug;
	private String to_address;

	private int result;	
	Properties prop = new Properties();
	
	public String execute() throws Exception {
		
        try {
            // test commit
    		prop.load(UserRegistrationAction.class.getClassLoader().getResourceAsStream("config.properties"));
            username = prop.getProperty("username");
            password = prop.getProperty("password");
        	smtpAuth = prop.getProperty("mail.smtp.auth");
        	smtpStarttlsEnable = prop.getProperty("mail.smtp.starttls.enable");
        	smtpHost = prop.getProperty("mail.smtp.host");
        	smtpPort = prop.getProperty("mail.smtp.port");
        	mailDebug = prop.getProperty("mail.debug");
            to_address = prop.getProperty("to_address");
            
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        
		Connection conn = null;
		try {
			if ((first_name != null && !first_name.trim().isEmpty())) {	
				if ((last_name != null && !last_name.trim().isEmpty())) {
					if ((email != null && !email.trim().isEmpty())) {
						if ((affiliation != null && !affiliation.trim().isEmpty())) {
							if ((motivation != null && !motivation.trim().isEmpty())) {
								System.out.println("first_name = " + first_name);
								
								conn = DBConnection.DATASOURCE.getConnection();
								
								PreparedStatement stmt = conn.prepareStatement(SqlQuery.CHECK_EMAIL.getSql());
								stmt.setString(1, email);
								ResultSet rs = stmt.executeQuery();
								
								if (!rs.next()) {
									
									PreparedStatement stmt2 = conn.prepareStatement(SqlQuery.INSERT_USER.getSql());
									stmt2.setString(1, first_name);
									stmt2.setString(2, last_name);
									stmt2.setString(3, email);
									stmt2.setString(4, affiliation);
									stmt2.setString(5, motivation);
									
									System.out.println("query = " + stmt2.toString());
									
									if (newsletter.equals("true")){
										stmt2.setInt(6, 1);
									}	
									else if (newsletter.equals("false")) {
										stmt2.setInt(6, 0);
									}
									
									int rs2 = stmt2.executeUpdate();
									System.out.println("query executed");
									
									//start

									Properties props = new Properties();
									props.put("mail.smtp.auth", smtpAuth);
									System.out.println("smtpAuth = " + smtpAuth);
									props.put("mail.smtp.starttls.enable", smtpStarttlsEnable);
									props.put("mail.smtp.host", smtpHost);
									props.put("mail.smtp.port", smtpPort);
									props.put("mail.debug", mailDebug);
									
									Session session = Session.getInstance(props,
									  new javax.mail.Authenticator() {
										protected PasswordAuthentication getPasswordAuthentication() {
											return new PasswordAuthentication(username, password);
										}
									  });

									try {

										Message message = new MimeMessage(session);
										message.setRecipients(Message.RecipientType.TO, InternetAddress.parse(to_address));
										message.setSubject("New registration request for ECASlab");
										message.setText("Registration details:" + 
										 "\n\n First name: " + first_name + 
										 "\n\n Last name: " + last_name + 
										 "\n\n Email address: " + email + 
										 "\n\n Affiliation: " + affiliation + 
										 "\n\n Motivation: " + motivation);

										Transport.send(message);
										
										System.out.println("new registration to ecas support sent");
										
										Message message2 = new MimeMessage(session);
										message2.setRecipients(Message.RecipientType.TO, InternetAddress.parse(email));
										message2.setSubject("ECASLab account request");
										message2.setText("Dear " + first_name + " " + last_name + "," +
										"\n\nThank you for registering to ECASLab." +
										"\n\nYour request is being processed. You will receive an email with the credentials soon." +
										"\n\nBest regards," +
										"\nThe ECASLab team" +
										"\n\nNOTE: If you didn't register to ECASLab, please contact us.");

										Transport.send(message2);										

									} catch (MessagingException e) {
										throw new RuntimeException(e);
									}
														
									//end
									
									if (rs2 == 1)
										result = 1;
									else
										result = 0;
									
								}
								else
									result = 2;
							}
							else {
								result = 3;
							}
						}
						else {
							result = 3;
						}	
					}
					else {
						result = 3;
					}
					
				}
				else {
					result = 3;
				}
			}
			else {
				result = 3;
			}
						
		} catch(SQLException e) {
			System.out.println("SQL exception = " + e.toString());
			result = 0;
		} finally {
			if(conn != null) conn.close();
		}
		return SUCCESS;
	}

	public void setFirst_name(String first_name) {
		this.first_name = first_name;
	}

	public void setLast_name(String last_name) {
		this.last_name = last_name;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public void setAffiliation(String affiliation) {
		this.affiliation = affiliation;
	}

	public void setMotivation(String motivation) {
		this.motivation = motivation;
	}

	public int getResult() {
		return result;
	}
	
	public String getNewsletter() {
		return newsletter;
	}

	public void setNewsletter(String newsletter) {
		this.newsletter = newsletter;
	}

}
