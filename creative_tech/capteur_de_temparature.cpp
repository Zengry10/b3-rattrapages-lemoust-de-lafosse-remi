
// Voici le code qui devrait faire fonctionner le thermomètre dans le cadre de mon rattrapage du devoir "Creative tech" :

#include <Wire.h>                     // Ajout de la bibbibloteque Wire pour la communication I2C
#include <LiquidCrystal_I2C.h>        // Ajout de la bibibloteque LiquidCrystal_I2C pour contrôler l'écran LCD via I2C

// On crée un objet 'lcd' pour gérer l'écran LCD avec l'adresse 0x27 et une taille de 16x2 caractères
LiquidCrystal_I2C lcd(0x27, 16, 2);

// On définit la broche à laquelle est connecté le capteur de température LM35
const int tempPin = A0;

void setup() {
  // Initialisation de l'écran LCD
  lcd.begin();
  lcd.backlight();                    // On allume le rétroéclairage de l'écran LCD
  
  // Initialisation de la communication série (pour le débogage)
  Serial.begin(9600);
}

void loop() {
  // Lecture de la tension du capteur de température
  int analogValue = analogRead(tempPin);
  
  // Conversion de la valeur analogique en température (Celsius)
  float temperature = analogValue * (5.0 / 1023.0) * 100.0;
  
  // Affichage de la température sur l'écran LCD
  lcd.clear();                        // On efface l'écran LCD pour afficher la nouvelle température
  lcd.setCursor(0, 0);                // On place le curseur au début de la première ligne
  lcd.print("Temp: ");                // On affiche le texte "Temp: "
  lcd.print(temperature);             // On affiche la température calculée
  lcd.print(" C");                    // On ajoute le symbole Celsius
  
  // Affichage de la température sur le moniteur série
  Serial.print("Temp: ");

  Serial.print(temperature);

  Serial.println(" C");
  
  
  // Délai avant la prochaine lecture
  delay(1000);                        // On attend 1 seconde avant de lire la température à nouveau
}
