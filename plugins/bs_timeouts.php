#!/usr/bin/env php
<?php
/**
 * @file
 * Beanstalkd "connections" Munin plugin.
 *
 * @author: Frédéric G. MARAND <fgm@osinet.fr>
 *
 * @copyright (c) 2014 Ouest Systèmes Informatiques (OSInet).
 *
 * @license Apache 2.0
 */

namespace OSInet\Beanstalkd\Munin;

require_once __DIR__ . "/../vendor/autoload.php";

class TimeoutsPlugin extends BasePlugin {
  /**
   * Implement Munin "config" command.
   */
  public function config() {
    $ret = <<<'EOT'
graph_title Job Timeouts
graph_vlabel Timeouts per ${graph_period}
graph_category Beanstalk
graph_args --lower-limit 0
graph_scale no
timeouts.label Timeouts
timeouts.type DERIVE
timeouts.min 0

EOT;

    return $ret;
  }

  /**
   * Implement Munin "data" command.
   */
  public function data() {
    $stats = $this->server->stats();
    $ret = sprintf("timeouts.value %d\n", $stats['job-timeouts']);
    return $ret;
  }
}

$p = TimeoutsPlugin::createFromGlobals();
echo $p->run($argv);

