<?php

trait Masteryl_DripAccess
{
    /**
     * Created: timestamp, uniq or other
     */

    public function dripAccess($created, $args = [])
    {
        if (empty($args) || empty($args['value'])) {
            return true;
        }

        if (is_string($created)) {
            $created = is_numeric($created) ? intval($created) : strtotime($created);
        }

        $elapsed = date('U') - $created;

        $str = $args['value'] . $args['units'];
        // $str = '900h';
        $drip = $this->strToNum($str);

        if ($elapsed < $drip) {
            return false;
        }

        $diff = $elapsed - $drip;

        /**
         * Set Time
         */
        if (!empty($args['tz'])) {
            $time = new DateTime('now', new DateTimeZone($args['tz']));
        } else {
            $time = new DateTime('now');
        }

        /**
         * Weekday
         */
        // 604800 = week (7 days)
        if (!empty($args['useWeekDay']) && isset($args['weekDay']) && $diff < 604800) {
            $weekday = intval($time->format('w'));

            if (intval($args['weekDay']) > $weekday) {
                return false;
            }
        }

        /**
         * Time (with timezone)
         */
        if (!empty($args['useTime']) && $diff < 86400) {
            $accessTime = explode(':', $args['time']);
            $accessHour = intval($accessTime[0]);

            $hour = intval($time->format('g'));

            if ($hour < $accessHour) {
                return false;
            }

            $hDiff = $hour - $accessHour;

            // Less than an hour, check miniutes
            if ($hour - $accessHour < 1) {
                $minute = intval($time->format('i'));
                $accessMin = intval($accessTime[1]);

                if ($minute < $accessMin) {
                    return false;
                }
            }
        }

        return true;
    }
}
