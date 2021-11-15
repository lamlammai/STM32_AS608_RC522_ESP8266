
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
#include <SoftwareSerial.h>

SoftwareSerial mySerial(D4, D5); //RX, TX



#define ON_Board_LED 2  //--> Defining an On Board LED, used for indicators when the process of connecting to a wifi router

//----------------------------------------SSID and Password of your WiFi router-------------------------------------------------------------------------------------------------------------//
const char* ssid = "CAM SAI KE";
const char* password = "0978887127";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

ESP8266WebServer server(81);  //--> Server on port 81



//-----------------------------------------------------------------------------------------------SETUP--------------------------------------------------------------------------------------//
void setup() {
 Serial.begin(115200); 
  mySerial.begin(115200);//--> Initialize serial communications with the PC

  delay(500);

  WiFi.begin(ssid, password); //--> Connect to your WiFi router
  Serial.println("");

  pinMode(ON_Board_LED, OUTPUT);
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off Led On Board

  //----------------------------------------Wait for connection
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    //----------------------------------------Make the On Board Flashing LED on the process of connecting to the wifi router.
    digitalWrite(ON_Board_LED, LOW);
    delay(250);
    digitalWrite(ON_Board_LED, HIGH);
    delay(250);
  }
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off the On Board LED when it is connected to the wifi router.
  //----------------------------------------If successfully connected to the wifi router, the IP Address that will be visited is displayed in the serial monitor
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  Serial.println("Please tag a card or keychain to see the UID !");
  Serial.println("");
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------------------------------------------------LOOP---------------------------------------------------------------------------------------//
void loop() {
  // put your main code here, to run repeatedly
 

    if(mySerial.available() > 1){//Read from  STM module and send to serial monitor
    String input = mySerial.readString(); 
   
    HTTPClient http;    //Declare object of class HTTPClient
    String UIDresultSend, postData;
    UIDresultSend = input;
    //Post Data
    postData = "UIDresult=" + UIDresultSend;
    http.begin("http://192.168.1.5:81/quanlysinhvien/getUID.php");  //Specify request destination
    http.addHeader("Content-Type", "application/x-www-form-urlencoded"); //Specify content-type header
    int httpCode = http.POST(postData);   //Send the request
    String payload = http.getString();    //Get the response payload
    Serial.println(UIDresultSend);
    Serial.println(httpCode);   //Print HTTP return code
    Serial.println(payload);    //Print request response payload
     mySerial.println(payload);
    http.end();  //Close connection
    delay(1000);
    digitalWrite(ON_Board_LED, HIGH);

  
  }
 
   
  
  
  
}
