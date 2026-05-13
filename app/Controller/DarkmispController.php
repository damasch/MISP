<?php
App::uses('AppController', 'Controller');

class DarkmispController extends AppController
{
    public $components = array('Session', 'RequestHandler');

    public $uses = array(
        'Event',
        'Attribute',
        'Organisation',
        'Correlation',
        'Tag',
        'EventTag',
        'AttributeTag',
        'GalaxyCluster',
        'GalaxyClusterRelation',
        'Feed',
        'Server'
    );

    public function index()
    {
        $this->set('title_for_layout', 'Dark MISP Dashboard');

        $scope = 'all';

        $user = $this->Auth->user();
        $myOrgId = isset($user['org_id']) ? (int)$user['org_id'] : 0;

        $parts = array();

        if (!empty($this->passedArgs)) {
            $parts = array_merge($parts, $this->passedArgs);
        }

        if (!empty($this->params['pass'])) {
            $parts = array_merge($parts, $this->params['pass']);
        }

        $searchOrg = 0;

        foreach ($parts as $partNname => $part) {
            if ($partNname === 'searchorg') {
                $searchOrg = (int)$part;
                break;
            }
        }

        if ($searchOrg === $myOrgId) {
            $scope = 'mine';
        }

        $eventConditions = array();
        if ($scope === 'mine' && $myOrgId > 0) {
            $eventConditions['Event.orgc_id'] = $myOrgId;
        }

        $eventCount = $this->Event->find('count', array(
            'conditions' => $eventConditions,
            'recursive' => -1
        ));

        $attributeCount = $this->__attributeCount($scope, $myOrgId);
        $objectCount = $this->__objectCount($scope, $myOrgId);
        $organisationCount = $this->__organisationCount();

        $topTags = $this->__topTags($scope, $myOrgId);
        $topTaxonomies = $this->__topTaxonomies($topTags);
        $topGalaxies = $this->__topGalaxies($scope, $myOrgId);
        $topOrganisations = $this->__topContributingOrganisations();
        $topCorrelations = $this->__topCorrelations($scope, $myOrgId);
        $topEventsWithRelations = $this->__topEventsWithRelations($scope, $myOrgId);

        $eventsByDay = $this->__eventsByLastDays($scope, $myOrgId);
        $objectsByDay = $this->__objectsByLastDays($scope, $myOrgId);
        $attributesByDay = $this->__attributesByLastDays($scope, $myOrgId);

        $latestEvents = $this->Event->find('all', array(
            'fields' => array('Event.id', 'Event.info', 'Event.date', 'Event.timestamp', 'Event.published'),
            'conditions' => $eventConditions,
            'order' => array('Event.timestamp' => 'DESC'),
            'limit' => 10,
            'recursive' => -1
        ));

        $latestObjects = $this->__latestObjects($scope, $myOrgId);
        $latestAttributes = $this->__latestAttributes($scope, $myOrgId);

        $health = $this->__healthStatus();
        $feedActivity = $this->__feedActivity();
        $syncActivity = $this->__syncActivity();

        $this->set(compact(
            'scope',
            'user',
            'parts',
            'myOrgId',
            'searchOrg',
            'eventCount',
            'attributeCount',
            'objectCount',
            'organisationCount',
            'topTags',
            'topTaxonomies',
            'topGalaxies',
            'topOrganisations',
            'topCorrelations',
            'topEventsWithRelations',
            'eventsByDay',
            'objectsByDay',
            'attributesByDay',
            'latestEvents',
            'latestObjects',
            'latestAttributes',
            'health',
            'feedActivity',
            'syncActivity'
        ));
    }

    private function __attributeCount($scope = 'all', $myOrgId = 0)
    {
        $sql = "
            SELECT COUNT(*) AS counter
            FROM attributes
            INNER JOIN events ON events.id = attributes.event_id
            WHERE attributes.deleted = 0
        ";

        if ($scope === 'mine' && $myOrgId > 0) {
            $sql .= " AND events.orgc_id = {$myOrgId}";
        }

        $result = $this->Event->query($sql);

        return isset($result[0][0]['counter']) ? (int)$result[0][0]['counter'] : 0;
    }

    private function __objectCount($scope = 'all', $myOrgId = 0)
    {
        $sql = "
            SELECT COUNT(*) AS counter
            FROM objects
            INNER JOIN events ON events.id = objects.event_id
            WHERE objects.deleted = 0
        ";

        if ($scope === 'mine' && $myOrgId > 0) {
            $sql .= " AND events.orgc_id = {$myOrgId}";
        }

        $result = $this->Event->query($sql);

        return isset($result[0][0]['counter']) ? (int)$result[0][0]['counter'] : 0;
    }

    private function __organisationCount()
    {
        $sql = "
            SELECT COUNT(*) AS counter
            FROM organisations
        ";

        $result = $this->Event->query($sql);

        return isset($result[0][0]['counter']) ? (int)$result[0][0]['counter'] : 0;
    }

    private function __topTags($scope = 'all', $myOrgId = 0)
    {
        $eventOrgJoin = '';
        $eventOrgWhere = '';
        $attributeOrgJoin = '';
        $attributeOrgWhere = '';

        if ($scope === 'mine' && $myOrgId > 0) {
            $eventOrgJoin = "INNER JOIN events e ON e.id = event_tags.event_id";
            $eventOrgWhere = "WHERE e.orgc_id = {$myOrgId}";

            $attributeOrgJoin = "
                INNER JOIN attributes a ON a.id = attribute_tags.attribute_id
                INNER JOIN events ae ON ae.id = a.event_id
            ";
            $attributeOrgWhere = "WHERE a.deleted = 0 AND ae.orgc_id = {$myOrgId}";
        }

        $sql = "
            SELECT 
                tags.id,
                tags.name,
                tags.colour,
                tags.is_galaxy,
                tags.local_only,
                COUNT(*) AS counter
            FROM tags
            INNER JOIN (
                SELECT event_tags.tag_id
                FROM event_tags
                {$eventOrgJoin}
                {$eventOrgWhere}

                UNION ALL

                SELECT attribute_tags.tag_id
                FROM attribute_tags
                {$attributeOrgJoin}
                {$attributeOrgWhere}
            ) used_tags ON used_tags.tag_id = tags.id
            GROUP BY tags.id, tags.name
            ORDER BY counter DESC
            LIMIT 10
        ";
        
        return $this->Tag->query($sql);
    }

    private function __topTaxonomies($topTags)
    {
        $taxonomies = array();

        foreach ($topTags as $row) {
            $name = $row['tags']['name'];
            $counter = (int)$row[0]['counter'];

            if (strpos($name, ':') === false) {
                continue;
            }

            $taxonomy = explode(':', $name, 2);
            $taxonomy = $taxonomy[0];

            if (!isset($taxonomies[$taxonomy])) {
                $taxonomies[$taxonomy] = 0;
            }

            $taxonomies[$taxonomy] += $counter;
        }

        arsort($taxonomies);

        return array_slice($taxonomies, 0, 10, true);
    }

    private function __topGalaxies($scope = 'all', $myOrgId = 0)
    {
        $eventJoin = '';
        $eventWhere = '';

        if ($scope === 'mine' && $myOrgId > 0) {
            $eventJoin = "
                INNER JOIN tags ON tags.name = galaxy_clusters.tag_name
                INNER JOIN event_tags ON event_tags.tag_id = tags.id
                INNER JOIN events ON events.id = event_tags.event_id
            ";
            $eventWhere = "WHERE events.orgc_id = {$myOrgId}";
        }

        $sql = "
            SELECT 
                galaxy_clusters.id,
                galaxy_clusters.value,
                galaxy_clusters.type,
                COUNT(*) AS counter
            FROM galaxy_clusters
            INNER JOIN galaxy_elements 
                ON galaxy_elements.galaxy_cluster_id = galaxy_clusters.id
            {$eventJoin}
            {$eventWhere}
            GROUP BY galaxy_clusters.id, galaxy_clusters.value, galaxy_clusters.type
            ORDER BY counter DESC
            LIMIT 10
        ";

        return $this->GalaxyCluster->query($sql);
    }

    private function __topContributingOrganisations()
    {
        $sql = "
            SELECT 
                organisations.id,
                organisations.name,
                COUNT(events.id) AS counter
            FROM organisations
            INNER JOIN events ON events.orgc_id = organisations.id
            GROUP BY organisations.id, organisations.name
            ORDER BY counter DESC
            LIMIT 5
        ";

        return $this->Event->query($sql);
    }

    private function __topCorrelations($scope = 'all', $myOrgId = 0)
    {
        $orgWhere = '';

        if ($scope === 'mine' && $myOrgId > 0) {
            $orgWhere = " AND events.orgc_id = {$myOrgId}";
        }

        $sql = "
            SELECT 
                attributes.id,
                attributes.event_id,
                attributes.type,
                CONCAT_WS('|', attributes.value1, NULLIF(attributes.value2, '')) AS value,
                COUNT(correlations.id) AS counter
            FROM correlations
            INNER JOIN attributes ON attributes.id = correlations.attribute_id
            INNER JOIN events ON events.id = attributes.event_id
            WHERE attributes.deleted = 0
            {$orgWhere}
            GROUP BY attributes.id, attributes.event_id, attributes.type, attributes.value1, attributes.value2
            ORDER BY counter DESC
            LIMIT 5
        ";

        return $this->Event->query($sql);
    }

    private function __topEventsWithRelations($scope = 'all', $myOrgId = 0)
    {
        $orgWhere = '';

        if ($scope === 'mine' && $myOrgId > 0) {
            $orgWhere = " AND events.orgc_id = {$myOrgId}";
        }

        $sql = "
            SELECT 
                events.id,
                events.info,
                events.date,
                COUNT(correlations.id) AS counter
            FROM events
            INNER JOIN attributes ON attributes.event_id = events.id
            INNER JOIN correlations ON correlations.attribute_id = attributes.id
            WHERE attributes.deleted = 0
            {$orgWhere}
            GROUP BY events.id, events.info, events.date
            ORDER BY counter DESC
            LIMIT 5
        ";

        return $this->Event->query($sql);
    }

    private function __eventsByLastDays($scope = 'all', $myOrgId = 0)
    {
        $days = array();

        for ($i = 9; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));

            $conditions = array(
                'Event.date' => $date
            );

            if ($scope === 'mine' && $myOrgId > 0) {
                $conditions['Event.orgc_id'] = $myOrgId;
            }

            $days[$date] = $this->Event->find('count', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
        }

        return $days;
    }

    private function __objectsByLastDays($scope = 'all', $myOrgId = 0)
    {
        $days = array();

        for ($i = 9; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $start = strtotime($date . ' 00:00:00');
            $end = strtotime($date . ' 23:59:59');

            $sql = "
                SELECT COUNT(*) AS counter
                FROM objects
                INNER JOIN events ON events.id = objects.event_id
                WHERE objects.deleted = 0
                AND objects.timestamp >= {$start}
                AND objects.timestamp <= {$end}
            ";

            if ($scope === 'mine' && $myOrgId > 0) {
                $sql .= " AND events.orgc_id = {$myOrgId}";
            }

            $result = $this->Event->query($sql);

            $days[$date] = isset($result[0][0]['counter']) ? (int)$result[0][0]['counter'] : 0;
        }

        return $days;
    }

    private function __attributesByLastDays($scope = 'all', $myOrgId = 0)
    {
        $days = array();

        for ($i = 9; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $start = strtotime($date . ' 00:00:00');
            $end = strtotime($date . ' 23:59:59');

            $sql = "
                SELECT COUNT(*) AS counter
                FROM attributes
                INNER JOIN events ON events.id = attributes.event_id
                WHERE attributes.deleted = 0
                AND attributes.timestamp >= {$start}
                AND attributes.timestamp <= {$end}
            ";

            if ($scope === 'mine' && $myOrgId > 0) {
                $sql .= " AND events.orgc_id = {$myOrgId}";
            }

            $result = $this->Event->query($sql);

            $days[$date] = isset($result[0][0]['counter']) ? (int)$result[0][0]['counter'] : 0;
        }

        return $days;
    }

    private function __latestObjects($scope = 'all', $myOrgId = 0)
    {
        $sql = "
            SELECT 
                objects.id,
                objects.name,
                objects.event_id,
                objects.timestamp
            FROM objects
            INNER JOIN events ON events.id = objects.event_id
            WHERE objects.deleted = 0
        ";

        if ($scope === 'mine' && $myOrgId > 0) {
            $sql .= " AND events.orgc_id = {$myOrgId}";
        }

        $sql .= "
            ORDER BY objects.timestamp DESC
            LIMIT 10
        ";

        return $this->Event->query($sql);
    }

    private function __latestAttributes($scope = 'all', $myOrgId = 0)
    {
        $sql = "
            SELECT 
                attributes.id,
                attributes.event_id,
                attributes.type,
                attributes.category,
                attributes.value1,
                attributes.value2,
                attributes.timestamp
            FROM attributes
            INNER JOIN events ON events.id = attributes.event_id
            WHERE attributes.deleted = 0
        ";

        if ($scope === 'mine' && $myOrgId > 0) {
            $sql .= " AND events.orgc_id = {$myOrgId}";
        }

        $sql .= "
            ORDER BY attributes.timestamp DESC
            LIMIT 10
        ";

        return $this->Event->query($sql);
    }

    private function __healthStatus()
    {
        return array(
            'database' => 'ok',
            'events' => $this->Event->find('count') > 0 ? 'ok' : 'warning',
            'attributes' => $this->__attributeCount() > 0 ? 'ok' : 'warning',
            'objects' => $this->__objectCount() > 0 ? 'ok' : 'warning',
            'feeds' => $this->Feed->find('count') > 0 ? 'ok' : 'warning',
            'sync' => $this->Server->find('count') > 0 ? 'ok' : 'warning'
        );
    }

    private function __feedActivity()
    {
        return $this->Feed->find('all', array(
            'fields' => array('Feed.id', 'Feed.name', 'Feed.enabled', 'Feed.caching_enabled', 'Feed.lookup_visible'),
            'order' => array('Feed.id' => 'DESC'),
            'limit' => 10,
            'recursive' => -1
        ));
    }

    private function __syncActivity()
    {
        return $this->Server->find('all', array(
            'fields' => array('Server.id', 'Server.name', 'Server.url', 'Server.pull', 'Server.push', 'Server.self_signed'),
            'order' => array('Server.id' => 'DESC'),
            'limit' => 10,
            'recursive' => -1
        ));
    }
}
