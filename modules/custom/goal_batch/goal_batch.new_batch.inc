<?php

/**
 * @file
 * Inc file for goal_batch.
 */

use Drupal\Component\Utility\Random;
use Drupal\Component\Uuid\Php;
use Drupal\node\Entity\Node;

/**
 * Batch execution.
 *
 * @param int $number
 *   Number of times to execute.
 * @param array $context
 *   An array of contextual key/value information for rebuild batch process.
 */
function _new_batch($number, array &$context) {
  if ($number && is_numeric($number)) {
    $message = \Drupal::translation()->formatPlural(
      $number,
      'One random string is listed below:', '@count article type nodes created:'
    );
    \Drupal::messenger()->addMessage($message);

    // Initiate multistep processing.
    if (empty($context['sandbox'])) {
      $context['sandbox']['progress'] = 0;
      $context['sandbox']['max'] = $number;
    }

    // Process the next 100 if there are at least 100 left. Otherwise,
    // we process the remaining number.
    $batch_size = 100;
    $max = $context['sandbox']['progress'] + $batch_size;
    if ($max > $context['sandbox']['max']) {
      $max = $context['sandbox']['max'];
    }

    // Start where we left off last time.
    $start = $context['sandbox']['progress'];
    for ($i = $start; $i < $max; $i++) {
      $code = randomString();
      $counter = $i + 1;
      $node = Node::create([
        'type' => 'article',
        'title' => Random::string(),
        'body' => $code,
      ]);
      $node->save();
      $context['sandbox']['progress']++;
    }

    if ($context['sandbox']['progress'] != $context['sandbox']['max']) {
      $context['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
    }
  }
}

/**
 * @return string
 *   Random strings.
 */
function randomString() {
  $uuid = new Php();
  $code = $uuid->generate();
  $code = strtoupper($code);
  return $code;
}
