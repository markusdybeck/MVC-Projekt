Redovisningar
====================================
 
###Kursmoment 1

Kul att vara tillbaka till detta kurspaket! De två tidigare kurserna (htmlphp & oophp) har jag haft lite förväntningar samt lite koll på vad de skulle handla om. Nu har jag inte haft en aning om vad denna kurs skulle gå ut på. Jag fick lite smått panik då jag antog att vi precis som i kursen oophp skulle göra om Anaxet till sitt egna, kände att det skulle bli otroligt mycket att ändra på och förstå. Men som tur var verkar det inte som vi behöver göra så nu när man använder sig av "teman".

I övrigt var anax-MVC lite komplicerat att förstå från början, men började lossna när man arbetat med guiden om att göra sin egna me-sida. Jag fick inte mina snygga länkar att fungera ifrån början, problemet var att jag hade lagt `$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);` efter `$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');` i min index.php. När jag bytte plats på dem så fungerade det som det skulle. Annars flöt momentet på rätt bra och jag stötte inte på några större problem än att jag klickade mig in i fel mapp när jag skulle plocka fram en fil lite då och då!

Jag har jobbat med lite olika ramverk tidigare som wordpress, men aldrig riktigt gått in på djupet i dem, så jag vet inte ifall det har gett mig någon fördel för att jobba med anax-mvc. Tycker inte att det var något speciellt begrepp som jag reagerade på, så det betyder nog att jag har stött på dem.

Till detta paket har jag gjort en ny design till min egna sida, där jag har fokuserat på att sidan skulle vara enkel att navigera och läsa sig igenom. Eftersom jag har blickat framåt lite över de nästkommande momenten så har jag redan nu lämnat en spalt till höger om denna artikelruta där man kan lägga in lite länkar mm. Samt att det går att smidigt lägga in en "highlight-del" ovanför dessa två spalter. Har hämtat lite inspiration av andernoren.se som är en väldigt duktigt designer som utvecklar wordpress teman. Där jag även fått inspiration att göra en "Style Guide" för att enklare få en överblick över ens element.

Har nyligen uppgraderat till Windows 10 (kanon!), där jag använder mig av xampp, filezilla och sublime text 2 när jag programmerar.


###Kursmoment2

**Generellt om momentet**  
Detta moment gick lite blandat för mig, mycket som inte flöt på samtidigt som jag kände att när det väl fungerade så hade jag förstått en hel del.

**Composer & Packagist**  
Jag kan inte riktigt säga att jag förstår meningen med att använda composer, det kändes bara som att man gjorde det krånligare att ladda ner filer. Först fungerade det inte heller även fast jag föröskte göra som i guiden, men genom att läsa på deras egna sida samt att kolla på en guide på youtube så lyckades jag ta mig igenom det och börja arbeta med själva kommentars sidan. Packagist kan jag tänka mig är en bra sida om man förstår sig på den helt och hållet. Jag däremor tycker även den verkar vara lite sådär, om man jämför med wordpress plugins -vilket jag tycker man borde göra- så behövde man inte enbart ladda ner det på ett krånligt sätt, utan sedan också flytta runt filer för att det skulle fungera. Inte i min smak.

**Klasser & Kontroller**  
Om jag tyckte delen med Composer och Packagist var ett litet överflödigt moment så måste jag säga att denna del var väldigt bra. Att utveckla kommentarsystemet gjorde att man behövde sätta sig in i hur anax fungerar. Jag hade svårt att första hur parametrarna i dispatchern fungerade ifrån början, men det lossnade tillslut. Det jag blev facinerad över var att alla delar som man behöver för att radera en kommentar, samt att editera en kommentar fanns redan med i koden. Jag har iprincip bara återanvänt de redan existerande funktionerna i klasserna och ändrat på några rader för att det skulle fungera.

Visst fanns det lite svagheter i koden som följde med phpmvc/comment. Man borde kanske kontrollera vad som skickas med i formuläret när man postar en kommentar, om det är en riktigt mailadress, ett riktigt namn osv. För att kontrollera det har jag gjort på enklast möjligast vis. Jag har gjort om formuläret så det är i html5, alltså bytt ut `type='text'` till respektive sak, `type='email'` osv. För namn och kommentar så har jag satt in `require` i slutet på input-fältet så att man måste skriva in dessa. Detta hade även gått att göra med lite php kontroller, men jag kände att detta var enklast nu.

###Kursmoment3

**Allmänt om kursmomenten.**

Kursmoment 3 har inte flutit på lika mycket som de andra momenten har gjort och det har tagit lite tid för mig att färdigställa det. Trots tiden det har tagit måste jag säga att resultatet är lite halvdant, men fyller nog kraven för vad som är nödvändigt.

Momentet i säg vet jag inte riktigt om jag var så förtjust i, jag tycker att vi har byggt på ett eget tema redan från början (vilket vi väl egentligen har) så jag tyckte mest att det blev att göra samma sak igen, det som var nytt var att vi använde LESS istället för CSS i princip.

Delen om hur man gör en sida responsiv kanske behöver uppdateras med att man bör lägga in `<meta name="viewport" content="width=device-width, initial-scale=1.0">` i sin index.tpl.php för att få sidan att fungera för mobila enheter och laptops. Som det beskrivs i guiden så fungerar det endast när man förminskar webben. Vilket jag inte riktigt tycker uppfyller kraven för dagens mening med responsiv design.

 

**Vad tycker du om CSS-ramverk i allmänhet och vilka tidigare erfarenheter har du av dem?**

För CSS-ramverk har jag en blandad smak, att ramverk som normalize och font-awesome finns är fantastiskt. Det är också bra att det finns ramverk som man kan använda för strukturen på sin sida. 
Nackdelen som jag ser med dessa ramverk är att man själv måste sätta sig in i dem rätt så ordentligt för att få allt att flyta på bra, och ifall det blir ett fel kan det vara svårt att hitta det.
Gör man en större webbplats tror jag att det kan vara värt investera i ett ramverk, men hittils tycker jag inte att det tagit sådan tid att strukturera upp sidan själv.
Jag har stött på normalize och använt mig av Font-Awesome sedan tidigare, innan Font-Awesome använde jag mig även en de av genericons.

 

**Vad tycker du om LESS, lessphp och Semantic.gs?**

LESS kan vara bra ifall man som sagt har en större webbplats, där filstrukturen blir mer komplicerad. Vad jag har förstått så gör det inget som vanlig CSS inte kan göra. Förutom att sätta upp variabler, vilket endast sparar arbete. Jag vart nyfiken ifall det inte redan gick att ordna med vanlig CSS.

Jag hittade någon artikel om att det var prat om att införa variabler i CSS, artikeln var dock från 2011 så det kanske lades på is. Vilket är synd, då det kanske hade varit bättre att jobba i samma sorts filer när skillnaden ändå inte är allt för markant. Kan ju såklart även vara så att jag inte riktigt greppat alla fördelar med LESS.

 

**Vad tycker du om gridbaserad layout, vertikalt och horisontellt?**

En vertikal gridbaserad layout är nog något som de flesta brukar sträva efter, även jag. Däremot har jag nog aldrig riktigt tänkt på den horisontella layouten, just att all text ligger jämsides med varandra oberoende vilket element som har varit. Det var lite svårt att bli insatt i det nu när vi endast laddade ner några filer och användes. Det kommer behövas lite extra tid för att sätta sig in och se hur det ”magiska” talet påverkar allting. Men det är definitivt något man bör kolla närmare på.

 

**Har du några kommentarer om Font Awesome, Bootstrap, Normalize?**

Jag gillar Font Awesome då det livar upp designen en hel del med väldigt små medel. Normalize är också ett bra verktyg för att få alla sidor att visa likartade designer oavsett element. Bootstrap har jag inte så mycket att säga om, inte så himla insatt i det och vet inte riktigt vad jag tycker än.

 

**Beskriv ditt tema, hur tänkte du när du gjorde det, gjorde du några utsvävningar?**

Mitt tema är dessvärre väldigt likt det vi gjorde i guiden och jag tog inte ut svängarna någonting. Jag stötte på lite problem här och där och försökte mest förstå mig på hur allt fungerade. Det blev lite krångligt när jag försökte koppla ihop menyn för att få ”snygga” länkar för båda template-filerna. Hittade någon tråd om det på forumet men det ville sig inte riktigt. Jag tänkte att jag nu har gjort en grund som går att bygga vidare på senare ifall man vill.

 

**Antog du utmaningen som extra uppgift?**

Jag kände att jag hade fullt upp med uppgiften i sig, så jag gjorde ingen extra uppgift denna gång.