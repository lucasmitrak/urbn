Saw Bones is named after the Mister Gutsy robots from Fallout.

Saw Bones is the (MDOC) Michigan Department of Corrections scraper.
It grabs the data from in sequence from the MDOC's OTIS database.
This is a public version of the real criminal database at the state level.
It puts it into a local database.
There is no reason to send the data as this program should be run on the 
main server.

To be ran on snode01.
Multiple instances and in segments
from 100,000
to 1,100,000

CRONTAB config (run every month on the first, eta 11 days)
crontab -e
* * 1 * * /root/sawbones/bladerunner.sh

8.31.2015
Tally
