Kravspecifikation och beskrivning av projekt
=============================================

Översiktlig beskrivning utav projekt.
----------------------------------------
En webbtjänst för att testa studenter på en mindre uppsättning frågor kopplade till ett kursmoment för att stämma av att vissa teoridelar har fastnat.
Studenterna besvarar frågorna genom en webbplats där de identifierar sig.
Frågorna skapas och hämtas via json.  

Studenten skall kunna köra testat godtyckligt antal gånger men för att vara elaka så sparas alla försök som en student gör, som kuriosa. Det får finnas en tidsbegränsning av hur länge man har på sig att besvara frågorna.

Gör vi 10 frågor så kan 5 slumpas fram, så studenten får delvis olika frågor varje gång. Vi får en statuskoll på hur bra vi når ut med "teorier" och studenten får något att stressa upp sig för, en kontroll.

Webbtjänsten måste sen kunna nås från dbwebb inspect-skriptet så vi kan se att studenten klarar denna delen.

Kravspecifikation (product backlog)
------------------------------------

| ID            | Beskrivning	| Prioritet | Kostnad(tid i timmar)
| ------------- |-------------  | ----------| ---------------------        
| F1            | Studenter skall kunna logga in på webbtjänsten| 1 | 20        
| F2            | Frågorna till testet skall hämtas ifrån en JSON-fil. | 1 | 8                             
| F3            | Testet skall slumpa fram frågor, så att studenten får olika frågor varje gång. | 2 | 8
| F4            | Testet skall ha en tidsbegränsning | 1 | 4
| F5            | Resultatet ifrån varje test skall sparas | 1 | 12
| F6            | Webbtjänsten skall kunna fuska sig igenom testet. D.v.s. att alla frågor inte behöver vara besvarade. | 2 | 20
| F7            | Webbtjänsten skall gå att nå via dbwebb inspect-skriptet | 2 | 30
