<?php

namespace App\Utils;

use Illuminate\Support\Collection;

class Inspiring {

    private static $quote_sets = [
        [
            'Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant',
            'An unexamined life is not worth living. - Socrates',
            'Be present above all else. - Naval Ravikant',
            'Happiness is not something readymade. It comes from your own actions. - Dalai Lama',
            'He who is contented is rich. - Laozi',
            'I begin to speak only when I am certain what I will say is not better left unsaid - Cato the Younger',
            'If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius',
            'It is not the man who has too little, but the man who craves more, that is poor. - Seneca',
            'It is quality rather than quantity that matters. - Lucius Annaeus Seneca',
            'Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci',
            'Let all your things have their places; let each part of your business have its time. - Benjamin Franklin',
            'No surplus words or unnecessary actions. - Marcus Aurelius',
            'Order your soul. Reduce your wants. - Augustine',
            'People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius',
            'Simplicity is an acquired taste. - Katharine Gerould',
            'Simplicity is the consequence of refined emotions. - Jean D\'Alembert',
            'Simplicity is the essence of happiness. - Cedric Bledsoe',
            'Simplicity is the ultimate sophistication. - Leonardo da Vinci',
            'Smile, breathe, and go slowly. - Thich Nhat Hanh',
            'The only way to do great work is to love what you do. - Steve Jobs',
            'The whole future lies in uncertainty: live immediately. - Seneca',
            'Very little is needed to make a happy life. - Marcus Antoninus',
            'Waste no more time arguing what a good man should be, be one. - Marcus Aurelius',
            'Well begun is half done. - Aristotle',
            'When there is no desire, all things are at peace. - Laozi',
        ],

        [
            'La vita è per il 10% cosa ti accade e per il 90% come reagisci. - Charles R. Swindoll',
            'Ci sono due regole nella vita: 1. Non mollare mai; 2. Non dimenticare mai la regola n° 1. - Duke Ellington',
            'Se vuoi qualcosa che non hai mai avuto, devi fare qualcosa che non hai mai fatto. - Thomas Jefferson',
            'Non si è mai troppo vecchi per fissare un nuovo obiettivo o per sognare un nuovo sogno. - C.S. Lewis',
            'Il futuro appartiene a coloro che credono nella bellezza dei propri sogni. - Eleanor Roosevelt',
            'Sembra sempre impossibile, finché non viene fatto. - Nelson Mandela',
            'Essere l’uomo più ricco del cimitero non ha importanza. Ciò che conta è andare a letto la sera sapendo di aver fatto qualcosa di grande. - Steve Jobs',
            'Non importa quanto vai piano, l’importante è non fermarsi. - Confucio',
            'Sii il cambiamento che vuoi vedere nel mondo. - Mahatma Gandhi',
            'Se non posso fare grandi cose, posso fare piccole cose in un modo fantastico. - Martin Luther King Jr.',
            'Noi diventiamo ciò che pensiamo. - Earl Nightingale',
        ],

        [
            'Se son rose, pungono. - La storia insegna',
            'Ama il tuo prossimo: non questo, il prossimo. - La storia insegna',
            'Ridi che è gratis - La storia insegna',
            'Chi tardi arriva è già a metà dell’opera. - La storia insegna',
            'Rosso di sera, hanno riacceso la ciminiera. - La storia insegna',
            'Errare è umano, muggire è bovino. - La storia insegna',
            'Chi trova un tesoro trova un amico. - La storia insegna',
            'Lo stupido cade sulla schiena e si sbuccia il naso. - (Proverbio Yiddish)',
            'I soldi non fanno la felicità, figuriamoci la miseria. - La storia insegna',
            'All’amore a prima vista spesso serve l’oculista. - La storia insegna',
            'L’ormone fa la forza. - La storia insegna',
            'Chi dorme non piglia pesci, piglia le goccine. - La storia insegna',
            'In vino veritas, in cronologia di più. - La storia insegna',
            'La calma è la virtù di chi non gliene frega un ..... che lo stai aspettando da tre quarti d’ora. - La storia insegna',
            'Chi non muore si rivede, ma alcuni se non li rivedi più è meglio. - La storia insegna',
            'Il mondo è bello ma è litigarello. - La storia insegna',
            'Non è bello ciò che è bello, è bello ciò che ti fa sangue. - La storia insegna',
            'Non è bello ciò che è bello lo dice il brutto. - La storia insegna',
            'Occhio non vede, mignolo duole. - La storia insegna',
            'La salma è la virtù dei morti. - La storia insegna',
            'Paese che vai, dementi che trovi - La storia insegna',
            'Una mano lava l’altra e ricordatevi delle ascelle - La storia insegna',
            'Il danaro non è tutto, ci sono anche i diamanti - La storia insegna',
            'Tra i due litiganti il terzo è l’avvocato. - La storia insegna',
            'Ride bene chi è al terzo Spritz. - La storia insegna',
            'Una mela al giorno… fanno 365 mele all’anno. - La storia insegna',
            'Se quando la vedi ti manca il respiro, non è amore. E\' allergia - La storia insegna',
            'Se non puoi convincerli, confondili - La storia insegna',
            'Ho un forte senso del dovrei - La moglie di Curley',
            'Il destino ce lo costruiamo noi. E\' fato a mano. - La storia insegna',
            'Dimostro meno danni di quelli che ho. - La storia insegna',
            'Dio deve proprio amare gli stupidi: ne ha creati così tanti. - La storia insegna',
            'Aveva la coscienza pulita. Mai usata. - Stanislaw Jerzy Lec'
        ]

    ];




    public static function quote($setId = 0)
    {
        $qs = self::$quote_sets;

        if(empty($qs) || ($setId >= count($qs)) || empty($qs[$setId])){
            return null;
        }

        return Collection::make($qs[$setId])->random();
    }
}
