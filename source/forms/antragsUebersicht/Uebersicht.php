<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_once(dirname(dirname(dirname(__FILE__))).'/backend/DbConnectivity.php');

class Uebersicht extends moodleform {
    //Add elements to form
    
    public function definition() {
        global $CFG;
        
        $mform = $this->_form;
        $dbConnectivity = new DbConnectivity();
        
        $anfrage_id = $_GET['anfrageid'];
        
        /**
         * Main part
         */
        $mform->addElement('select', 'responsible', get_string('responsible', 'mod_firmenzulassung'),
            $dbConnectivity->getResponsibles($anfrage_id)['name'],
            $dbConnectivity->getResponsibles($anfrage_id)['user_id']);
        
        $mform->setDefault('responsible', $dbConnectivity->getCurrentResponsible($anfrage_id));
        $mform->addGroup([$mform->createElement('html', '<text style="color: rgb(250, 70, 50); font-weight:  bold;">' . get_string('status' . $dbConnectivity->getCurrentStatus($anfrage_id), 'mod_firmenzulassung') . '</text>')],
                         'status', get_string('status', 'mod_firmenzulassung'), array(' '), false);
        $mform->addElement('static', 'requestDate', get_string('antragsdatum', 'mod_firmenzulassung'), $dbConnectivity->getRequestDate($anfrage_id));
        $mform->addElement('select', 'studiengang', get_string('studiengang', 'mod_firmenzulassung'),
                          $dbConnectivity->getStudiengangs()['name'],
                          $dbConnectivity->getStudiengangs()['id']);
        
        /**
         * 1. Angaben zum Antragsteller als Unternehmen
         */
        $mform->addElement('header', 'angabenZumAntragstellerAlsUnternehmen', get_string('subtitle1', 'mod_firmenzulassung'));
        $mform->addElement('static', 'vorname', get_string('vorname', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["vorname"]);
        $mform->addElement('static', 'nachname', get_string('nachname', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["nachname"]);        
        $mform->addElement('static', 'email', get_string('email', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["email"]);
        $mform->addElement('static', 'tel', get_string('tel', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["tel"]);
        $mform->addElement('static', 'fax', get_string('fax', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["angesteller"]["fax"]);        
        
        /**
         * 2. Anhaben zum Unternehmen
         */
        $mform->addElement('header', 'angabenZumUnternehmen', get_string('subtitle2', 'mod_firmenzulassung'));
        $mform->closeHeaderBefore('angabenZumUnternehmen');
        
        $mform->addElement('html', '<table style="width: 100%">');
        $mform->addElement('html', '<tr><td colspan=2>');
        $mform->addElement('static', 'name', get_string('name', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["name"]);
        $mform->addElement('html', '</td></tr><tr><td colspan=2>');
        $mform->addElement('static', 'branche', get_string('branche', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["branche"]);        
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'mitgliedKammer', get_string('mitgliedKammer', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["mitgliedKammer"]);        
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'in', get_string('in', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["in"]);        
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'anzahlMitarbeiter', get_string('anzahlMitarbeiter', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["anzahlMitarbeiter"]);        
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'anzahlKaufmAusbildenden', get_string('anzahlKaufmAusb', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["anzahlKaufmAusbildenden"]);        
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'anzahlTechnischenAusbildenden', get_string('anzahlTechnischenAusb', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["anzahlTechnischenAusbildenden"]);        
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'anzahlSonstigerAusbildenden', get_string('anzahlSonstigerAusb', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["anzahlSonstigerAusbildenden"]);        
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'stadt', get_string('stadt', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["stadt"]);
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'postleitzahl', get_string('postleitzahl', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["postleitzahl"]);
        $mform->addElement('html', '</td></tr><tr><td>');
        $mform->addElement('static', 'strasse', get_string('strasse', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["strasse"]);
        $mform->addElement('html', '</td><td>');
        $mform->addElement('static', 'nummer', get_string('nummer', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["unternehmen"]["nummer"]);
        $mform->addElement('html', '</td></tr></table>');
        
        $mform->addElement('static', 'divBetween345', '', '');
        $mform->closeHeaderBefore('divBetween345');
        
        /**
         * 3. Angaben zur Ausbildung
         */
        $mform->addElement('html', '<table style="width: 100%"><tr><td>');
        
        $mform->addElement('header', 'angabenZurAusbildung', get_string('subtitle3', 'mod_firmenzulassung'));
        $mform->addElement('static', 'verguetung', get_string('verguetung', 'mod_firmenzulassung'), $dbConnectivity->getMetaData($anfrage_id)["ausbildung"]["verguetung"]);
        
        // radio buttons for inhalte des a.bildungplanes
        $inhalte=array();
        $inhalte[] = $mform->createElement('radio', 'inhalte', '', get_string('internVollVermittelt', 'mod_firmenzulassung'), 0);
        $inhalte[] = $mform->createElement('radio', 'inhalte', '', get_string('internTeilVermittelt', 'mod_firmenzulassung'), 1);
        $mform->addGroup($inhalte, 'inhalteGroup', get_string('ausbildungsplanInhalte', 'mod_firmenzulassung'), array(' '), false);
        
        // Download option
        $mform->addGroup([$mform->createElement('html', '<button style="background: url(icons/downloadIcon.png); background-repeat: no-repeat; background-size: 100%; border: none; height: 33px; width: 33px;"/>')],
                         'downloadGroup', get_string('ausbildungsplanStud', 'mod_firmenzulassung'), array(' '), false);
        
        $mform->addElement('html', '</td><td>');
        
        /**
         * 4. Antragsbearbeitung
         */
        $mform->addElement('header', 'antragsbearbeitung', '4. Antragsbearbeitung');
        $mform->closeHeaderBefore('antragsbearbeitung');
        
        // Radio buttons for Inhalte des Ausbildungsplanes.
        // Alone stading radio buttons must be in group as well, otherwise gets misaligned
        // due to opt2, where a date selector is next to the option.
        $mform->addGroup([$mform->createElement('radio', 'aufnahme', '', get_string('aufnahme1', 'mod_firmenzulassung'), 0)],
                        'aufnahmeG1', '', array(' '), false);
        $inhaltOption2=array();
        $inhaltOption2[] = $mform->createElement('radio', 'aufnahme', '', get_string('aufnahme2', 'mod_firmenzulassung'), 1);
        $inhaltOption2[] = $mform->createElement('date_selector', 'inhaltOpt2DS', '');
        $mform->addGroup($inhaltOption2, 'aufnahmeG2', get_string('aufnahmeText', 'mod_firmenzulassung'), array(' '), false);
        
        $mform->addGroup([$mform->createElement('radio', 'aufnahme', '', get_string('aufnahme3', 'mod_firmenzulassung'), 0)],
                         'aufnahmeG3', '', array(' '), false);        
        
        $mform->addElement('select', 'zulassung', get_string('zulassungStudiengang', 'mod_firmenzulassung'),
                           ["nicht zutreffend"],
                           [0]);
                
        $mform->addElement('html', '</td></tr></table>');
        
        /**
         * Zulassungsprozess
         */
        $mform->addElement('header', 'zulassungsprozess', get_string('subtitleFinal', 'mod_firmenzulassung'));
        $mform->closeHeaderBefore('zulassungsprozess');
        
        $currentStep = $dbConnectivity->getCurrentStatus($anfrage_id);
        
        $part1 = '';
        $part2 = '';
        for ($i = 0; $i <=3; $i++) {
            if ($i < $currentStep) {
                $part1 = $part1 . get_string('zulassung' . $i, 'mod_firmenzulassung') . " > ";
            } elseif ($i == $currentStep) {
                $part1 = $part1 . get_string('zulassung' . $i, 'mod_firmenzulassung');
            } else {
                $part2 = $part2 . " > " . get_string('zulassung' . $i, 'mod_firmenzulassung');
            }
        }
        
        $mform->addElement('html', '<div><text style="color: rgb(250, 70, 50); font-weight:  bold;">' . $part1 .
                                 '</text><text style="color: rgb(180, 175, 175); font-weight:  bold;">' . $part2 . '</text></div>');
        
        $mform->addElement('checkbox', 'besichtigt',  get_string('besichtigt', 'mod_firmenzulassung'));
        $mform->addElement('date_selector', 'datumUNehmenBes', get_string('datumUNBes', 'mod_firmenzulassung'));

        
        // error_log("TEST FROM INSIDE FORM");
        
        $mainButons=array();
        $mainButons[] =& $mform->createElement('submit', 'genehmigen', get_string('genehmigen', 'mod_firmenzulassung'));
        $mainButons[] =& $mform->createElement('submit', 'ablehen', get_string('ablehen', 'mod_firmenzulassung'));
        $mainButons[] =& $mform->createElement('html', '<div class="form-group fitem"><button onclick="window.print()" style="background: url(icons/printIcon.png); background-repeat: no-repeat; background-size: 100%; border: none; height: 33px; width: 33px;"/></div>');
        $mform->addGroup($mainButons, 'mainBtns', '', array(' '), false);
        
        
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        
        
        $mform->closeHeaderBefore('mainBtns');
        
        $mform->setExpanded('angabenZumAntragstellerAlsUnternehmen', true);
        $mform->setExpanded('angabenZumUnternehmen', true);
        $mform->setExpanded('angabenZurAusbildung', true);
        $mform->setExpanded('antragsbearbeitung', true);
        $mform->setExpanded('zulassungsprozess', true);
        
    }
    
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}