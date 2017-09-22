Kravspecifikation och beskrivning av projekt
=============================================

Översiktlig beskrivning utav projekt.
----------------------------------------
En webbtjänst för att testa studenter på en mindre uppsättning frågor kopplade till ett kursmoment för att stämma av att vissa teoridelar har fastnat.
Studenterna besvarar frågorna genom en webbplats där de identifierar sig.
Frågorna hämtas från en JSON-fil som redigeras manuellt.  

Studenten skall kunna köra testet godtyckligt antal gånger men för att vara elaka så sparas alla försök som en student gör, som kuriosa. Det skall finnas en tidsbegränsning av hur länge man har på sig att besvara frågorna.

Frågorna skall slumpas fram så att studenten får delvis olika frågor varje gång. På så sätt får vi en statuskoll på hur bra vi når ut med "teorier" och studenten får något att stressa upp sig för, en kontroll.

Webbtjänsten skall nås från dbwebb inspect-skriptet så man kan se att studenten klarar den delen.


Krav
------------------------------------

1. Studenter skall kunna logga in på webbtjänsten.       
2. Frågorna till testet skall hämtas ifrån en JSON-fil.                            
3. Testet skall slumpa fram frågor, så att studenten får olika frågor varje gång.
4. Testet skall ha en tidsbegränsning.
5. Resultatet ifrån varje test skall sparas till en databas. Tillsammans med tid på testet, antal gånger testet är gjort samt svaren på frågorna.
6. Webbtjänsten skall kunna fuska sig igenom testet. D.v.s. att alla frågor inte behöver vara besvarade.
7. Webbtjänsten skall gå att nå från dbwebb inspect-skriptet via ett API för webbtjänsten. 
API:t skall kunna svara på frågor om status för en viss student eller ett test.
