// Voici le code qui devrait faire fonctionner le thermomètre dans le cadre de mon rattrapage du devoir "Creative tech" :

#include <Wire.h>                     // Bibliothèque pour la communication I2C (non nécessaire ici, mais utile pour l'avenir)
#include <LiquidCrystal_I2C.h>        // Bibliothèque pour l'écran LCD (non nécessaire ici, mais utile pour l'avenir)

// On définit la broche à laquelle est connecté le capteur de température LM35
const int tempPin = A0;               // Utilisé avec l'Arduino pour lire la sortie du LM35

void setup() {
  Serial.begin(9600);                // Initialisation de la communication série pour afficher les données
}

void loop() {
  int analogValue = analogRead(tempPin);   // Lecture de la tension du capteur de température
  float temperature = analogValue * (5.0 / 1023.0) * 100.0; // Conversion de la tension en température en Celsius
  
  
  Serial.print("Temp: ");
  Serial.print(temperature);             // Affichage de la température sur le moniteur série
  Serial.println(" C");



  delay(1000);                          // Délai avant la prochaine lecture
}