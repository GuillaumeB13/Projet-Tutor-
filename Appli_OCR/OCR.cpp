// Compilation du script : g++ OCR.cpp tinyxml2.cpp base64.cpp -o OCR.exe -ltesseract -llept -L./SFML-2.0-rc/lib/ -lsfml-graphics

// export TESSDATA_PREFIX=/usr/share/tesseract-ocr/ => .bashrc 

#include <tesseract/baseapi.h>
#include <leptonica/allheaders.h>
#include <iostream>
#include <cstdlib>
#include <fstream>
#include <SFML/Graphics.hpp>
#include "OCR.h"
#include "tinyxml2.h"
#include "base64.hpp"


using namespace std;
using namespace tesseract;
using namespace tinyxml2;
using namespace sf;

string content, endFile;
unsigned int x1,x2,y1,y2;
ifstream configFile("/var/www/html/OCR/php/config.txt", ios::in);

int main()
{
  if(configFile && resFile)
  {
    // initialisation du document xml
    XMLDocument xmlDoc;
    // création noeud 
    XMLNode * info = xmlDoc.NewElement("Info");
    xmlDoc.InsertFirstChild(info);
    do
    { 
      //initialisation variable de décupération
      string res="";
      //récupération des données du fichier de configuration
      configFile >> content >> x1 >> y1 >> x2 >> y2 >> endFile;

      // création d'un enfant du noeud
      const char * contentChar = content.c_str();
      XMLElement * element = xmlDoc.NewElement(contentChar);
      // récupération des données en fonction du type de données (champs texte ou image)
      if(content == "PhotoID" or content == "Signature")
        res=imageToBinary(x1,y1,x2,y2);
      else
        res = fileToString(x1,y1,x2,y2);

      // écriture fichier XML
      const char * resChar=res.c_str();
      element->SetText(resChar);
      info->InsertEndChild(element);
    }while(endFile!="f");
    // sauvegarde du document xml
    XMLError eResult = xmlDoc.SaveFile("/var/www/html/OCR/php/SavedData.xml");
    // vérifie le bon déroulement
  }
  else 
    cerr <<"erreur lecture fichier" <<endl;
  return 0;
}




string fileToString(unsigned short x1, unsigned short y1, unsigned short x2, unsigned short y2)
{
 // on lit l'image avec leptonica
  Pix *image = pixRead("/var/www/html/OCR/php/img/ci.png");
  // on initialise l'api tesseract ocr (langue française, application de l'image récupéré)
  TessBaseAPI *api = new TessBaseAPI();
  api->Init("/usr/share/tesseract-ocr/tessdata", "fra");
  api->SetImage(image);
  // création de la box de récupération de caractères
  Boxa* boxes = api->GetComponentImages(RIL_WORD, false, NULL, NULL);
  // définition de la box de récupération
  api->SetRectangle(x1, y1, x2, y2);
  // récuperation du résultat contenu dans la box
  char* ocrResult = api->GetUTF8Text();
  return ocrResult;
  api->End();
  delete [] ocrResult;   
  pixDestroy(&image);
}

string imageToBinary(unsigned short x1, unsigned short y1, unsigned short x2, unsigned short y2)
{
  // chargement de l'image
  Image imgBase,copyImg;
  imgBase.loadFromFile("/var/www/html/OCR/php/img/ci.png");
  // initialisation de la copie et recopie de la zone
  copyImg.create(x2,y2);
  copyImg.copy(imgBase, 0, 0, sf::IntRect(x1,y1,x2,y2), false);
  copyImg.saveToFile("/var/www/html/OCR/php/img/copy.png");
  //ouverture de la copie de l'image en mode binaire
  ifstream imgBin("/var/www/html/OCR/php/img/copy.png", ios::binary);
  char c;
  // récupération de l'image en binaire
  string strResult;
  while(imgBin.get(c))
    strResult.push_back(c);
  // encodage en base 64
  string encoded2 = base64_encode(reinterpret_cast<const unsigned char*>(strResult.c_str()), strResult.length());
  // envois du résultat
  return encoded2;

}