<?php
namespace App;

use Exception;
use CaptainHook\App\Config;
use CaptainHook\App\Config\Action;
use CaptainHook\App\Console\IO;
use CaptainHook\App\Hook\Action as HookAction;
use SebastianFeldmann\Git\Repository;
use function in_array;
use function join;
use function levenshtein;
use function preg_match;
use function sprintf;
use function trim;
use const PHP_INT_MAX;

class GitCommitMsgHook implements HookAction {

	private const array COMMIT_TYPES = ['fix', 'feat', 'build', 'chore', 'ci', 'docs', 'style', 'refactor', 'perf', 'test'];
	private const array COMMIT_ICONS = ['art', 'zap', 'fire', 'bug', 'ambulance', 'sparkles', 'memo', 'rocket', 'lipstick', 'tada', 'white_check_mark', 'lock', 'closed_lock_with_key', 'bookmark', 'rotating_light', 'construction', 'green_heart', 'arrow_down', 'arrow_up', 'pushpin', 'construction_worker', 'chart_with_upwards_trend', 'recycle', 'heavy_plus_sign', 'heavy_minus_sign', 'wrench', 'hammer', 'globe_with_meridians', 'pencil2', 'poop', 'rewind', 'twisted_rightwards_arrows', 'package', 'alien', 'truck', 'page_facing_up', 'boom', 'bento', 'wheelchair', 'bulb', 'beers', 'speech_balloon', 'card_file_box', 'loud_sound', 'mute', 'busts_in_silhouette', 'children_crossing', 'building_construction', 'iphone', 'clown_face', 'egg', 'see_no_evil', 'camera_flash', 'alembic', 'mag', 'label', 'seedling', 'triangular_flag_on_post', 'goal_net', 'dizzy', 'wastebasket', 'passport_control', 'adhesive_bandage', 'monocle_face', 'coffin', 'test_tube', 'necktie', 'stethoscope', 'bricks', 'technologist', 'money_with_wings', 'thread', 'safety_vest'];
	private const string REGEX = '/^(?<type>[a-z]+)(?:\\((?<scope>[[:alnum:]_-]+)\\))?:\\s:(?<icon>[a-z_]+):/';

	public function execute(Config $config, IO $io, Repository $repository, Action $action): void {
		$match = [];
		$message = trim($repository->getCommitMsg()->getContent());
		if (!preg_match(self::REGEX, $message, $match) || !@$match['type'] || !@$match['icon'])
			throw new Exception("The commit message '{$message}' does not complain the requirements. The format is: '<type>[(<scope>)]: <icon> <message>'");
		if (!in_array(@$match['type'], self::COMMIT_TYPES))
			throw new Exception(sprintf(
				'The commit message \'%s\' has an unallowed type \'%s\'. The allowed values are: %s. Did you mean \'%s\'?',
				$message,
				$match['type'],
				join(', ', self::COMMIT_TYPES),
				self::findClosest($match['type'], self::COMMIT_TYPES)
			));
		if (!in_array(@$match['icon'], self::COMMIT_ICONS))
			throw new Exception(sprintf(
				'The commit message \'%s\' has an unallowed icon \'%s\'. The allowed values are: %s. Did you mean \'%s\'?',
				$message,
				$match['icon'],
				join(', ', self::COMMIT_ICONS),
				self::findClosest($match['icon'], self::COMMIT_ICONS)
			));
	}

	private static function findClosest(string $string, array $haystack): string {
		$match = '';
		$diff = PHP_INT_MAX;
		foreach ($haystack as $s) {
			$sDiff = levenshtein($string, $s);
			if ($sDiff < $diff) {
				$diff = $sDiff;
				$match = $s;
			}
		}
		return $match;
	}
}
