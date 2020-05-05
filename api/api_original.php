
$DB_HOST='astrazeneca.cluster-cisyqmww9qkn.us-east-1.rds.amazonaws.com';
$DB_USER='admin';
$DB_PASS='7TDcwSSzXscpOrTDG2TM';
$DB_NAME='asmazero';

$db =  new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$db->set_charset('utf8mb4');
$data = [];
// Notes
$query = $db->query("SELECT * from aza_notes where `status` = 1 ORDER BY `full_date` DESC");
$notes = $query->fetch_all(MYSQLI_ASSOC);
foreach ($notes as $key => $item) {
    $id_section = $item['id_section'];
    $sectionq = $db->query("SELECT * from aza_sections where `id_section` = $id_section");
    $notes[$key]["section"] = $sectionq->fetch_all(MYSQLI_ASSOC)[0];

    $id_note_author = $item['id_note_author'];
    $authorq = $db->query("SELECT * from aza_notes_authors where `id_note_author` = $id_note_author");
    $notes[$key]["author"] = $authorq->fetch_all(MYSQLI_ASSOC)[0];
    
    $id_note = $item['id_note'];
    $resourcesq = $db->query("SELECT id_note_resource from aza_notes_resources_relations where `id_note` = $id_note");
    $resourcesids = $resourcesq->fetch_all(MYSQLI_ASSOC);
    $notes[$key]["resources"] = [];
    foreach ($resourcesids as $key => $id) {
        $id_note_resource = $id["id_note_resource"];
        $resourceq = $db->query("SELECT * from aza_notes_resources where `id_note_resource` = $id_note_resource");
        $resource = $resourceq->fetch_all(MYSQLI_ASSOC)[0];
        $notes[$key]["resources"][] = $resource;
    }
}
$data['notes'] = $notes;
// Events
$query = $db->query("SELECT * from aza_events where `status` = 1  ORDER BY `date` DESC");
$events = $query->fetch_all(MYSQLI_ASSOC);
$data['events'] = $events;
// Mapa
$query = $db->query("SELECT * from aza_maps where `status` = 1");
$maps = $query->fetch_all(MYSQLI_ASSOC);
$data['mapa'] = $maps;
// Response
header('Content-type: application/json');
$json = json_encode($data);
echo($json);
 