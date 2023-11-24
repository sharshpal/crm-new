# v. 1.1.15
## 04/05/2022
- Rimossa stampa dd() in calcolo tempo retribuito "TEMPI CHIAMATA"

# v. 1.1.14
## 04/05/2022
- In file .env, rinominato parametro "PAUSE_COMPUTE_METHOD" in "PAYTIME_COMPUTE_METHOD" e aggiunto un terzo metodo di calcolo
 
# v. 1.1.13
## 04/05/2022
- In file .env, aggiunto parametro "PAUSE_COMPUTE_METHOD" per impostare il metodo di calcolo della pausa, nella pagina "Tempi chiamata"

# v. 1.1.12
## 02/05/2022
- In pagina "Tempi Chiamata" rimosso "dead_sec" dal conteggio

# v. 1.1.11
## 14/04/2022
- In pagina "Tempi Chiamata", impostato formato hh:mm:ss

# v. 1.1.10
## 16/03/2022
- Gestione allegati su split

# v. 1.1.9
## 09/03/2022
- Aggiunto comando artisan "php artisan crm:split-dual" -> separa i dual lucegas in due contratti (1 luce e 1 gas)
- Rimossa forzatura cancellazione filtri dopo modifica esito da pagina elenco contratti

# v. 1.1.8
## 08/03/2022
- Fix mantenimento filtri
- In lista contratti, unite le colonne telefono e cellulare, aggiunta colonna con pod/pdr

# v. 1.1.7
## 08/03/2022
- Fix su estrazione partner utente

# v. 1.1.6
## 07/03/2022
- Ottimizzazione kb cookie filtri
- pulizia cookie residui on exit

# v. 1.1.5
## 28/02/2022
- Fix migration

# v. 1.1.4
## 28/02/2022
- Fix migration

# v. 1.1.3
## 28/02/2022
- I contratti dual vengono sdoppiati in contratti singoli (sia in create che update)

# v. 1.1.2
## 03/02/2022
- Aggiunto metodo di pagamento carta di credito

# v. 1.1.1
## 22/12/2021
- Fix gestione campo created_at in dati_contratto quanto utente non ha permesso di modificare la data

# v. 1.1.0
## 18/12/2021
- Aggiornamento librerie
- Fix calcolo rese operatore
- Fix filtri statistiche chiamata

# v. 1.0.12
## 14/12/2021
- fix gestione campo dati_contratto.created_at in base ad esiti operatore

# v. 1.0.11
## 13/12/2021
- upgrade laravel ignition

# v. 1.0.10
## 12/12/2021
- Fix filtri rese operatore
- Migliorate performance caricamento, in alcune query è stato rimosso il caricamento automatico dei media per ridurre il numero di query complessivo
- Aggiunta paginazione in rese operatore per alleggerire il carico
- Aggiornato update.sh
- Miglioramento grafica rese operatore

# v. 1.0.9
## 12/12/2021
- Fix call function profiler

# v. 1.0.8
## 12/12/2021
- Fix in export dati contratto
- Fix query rese operatore
- Statistiche esiti - aggiunta visualizzazione schede/Pezzi Rese Operatore, migliorata visualizzazione - aggiunto lordo in export
- Aggiunto parametro in env che include/esclude ko dalle rese operatore
- Create migration con index per altre tabelle
- Installato profiler, minifix su query
- Fix file upload campagna/partner/profilo

# v. 1.0.7
## 30/11/2021
- Fix in export dati contratto

# v. 1.0.6
## 30/11/2021
- Fix in export dati contratto, quando di sono riferimenti a update_user o crm_user che risultano con "deleted_at"

# v. 1.0.5
## 28/11/2021
- Aggiunto tag title su tutte le label dei campi data in dati_contratto

# v. 1.0.4
## 28/11/2021
- Fix user timelog - filtri date
- Aggiunta funzionalità di limite massimo richiami per ora + calendario in form dati_contratto
- Aggiunto piva e ragione sociale in search contratto
- Consentiti pdf + jpeg per caricamento file
- Aggiunta visualizzazione utente ultima modifica in show/edit dati_contratto, solo per admin
- Fix recall
- Aggiunti permessi per visualizzazione file uploader in dati contratto
- Aggiunta possibilità di modificare le note bo da elenco contratti se utente ha permesso
- Aggiunto pulsante "Mantieni Filtri On/Off" in lista contratti
- Aggiunta possibilità di caricare immagine campagna
- Aggiunta possibilità di caricare immagine partner
- Fix post inserimento immagini
- Inserite immagini partner/campagna/user un elenco contratti e altri punti
- Fix filtri stesso partner/campagna user_timelog + fix permessi dati_contratto upload file
- User_timelog -> ordinamento default data desc
- Aggiunti campi dati contratto
- Fix file migration
- Fix Edit User + Aggiunto calcolo rese telefonia
- Pulitura dati su export dati contratto

# v. 1.0.3
## 26/10/2021
- Fix unique name campagna/partner


# v. 1.0.2
## 26/10/2021
- Inserimento ore: nascosti i minuti (default 0) - le ore sono diventate decimali
- Rese operatore: vengono visualizzati tutti i record, anche se hanno zero ore o zero pezzi

# v. 1.0.1
## 25/10/2021
- Fix minori
- Campi data_nascita, data_scadenza, data_rilascio, ora è stato inserito il plugin calendario
- Nome campagna e nome partner adesso sono unique (solo lato php e considerando solo quelli non cancellati)
- Miglioramento della pagina "Statistiche Esiti"

# v. 1.0.0
## 16/10/2021
- Primo Versione Taggata
