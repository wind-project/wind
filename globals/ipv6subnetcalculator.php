<?php
/**
 * The goal of this class is to give basic information about a given
 * IPv6 subnet.
 * 
 * It will provide the following information
 * - Abbreviated form of IPv6 Address
 * - Non-abbreviated form of IPv6 address
 * - Start and end address for a given subnet
 * - The number of interfaces in this subnet
 * - The subnet mask
 * 
 *
 * @author Ben Burkhart <benburkhart1@gmail.com>
 * https://github.com/benburkhart1/ipv6-subnet-calculator/blob/master/IPV6SubnetCalculator.php
 */
class IPV6SubnetCalculator
{
	/**
	 * Determines if a given IPv6 address is a valid address.
	 * 
	 * @param string $address An IPv6 address.
	 * @return boolean true if IPv6 address is valid.
	 */
	public function testValidAddress($address)
	{
		// 8 groups of 4 hexidecimal characters
		return (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== FALSE);
	}
	/**
	 * This unabbreviates an abbreviated address
	 *
	 * @param string $address an IPv6 Address
	 * @return string an unabbreviated IPv6 address
	 */
	public function unabbreviateAddress($address)
	{
		$unabbv = $address;
		if (strpos($unabbv, "::") !== FALSE)
		{
			$parts = explode(":", $unabbv);
			$cnt = 0;
			// Count number of parts with a number in it
			for ($i=0; $i < count($parts); $i++)
			{
				if (is_numeric("0x" . $parts[$i]))
					$cnt++;
			}
			// This is how many 0000 blocks is needed
			$needed = 8 - $cnt;
			$unabbv = str_replace("::", str_repeat(":0000", $needed), $unabbv);
		}	
		$parts = explode(":", $unabbv);
		$new   = "";
		// Make sure all parts are fully 4 hex chars
		for ($i = 0; $i < count($parts); $i++)
		{
			$new .= sprintf("%04s:", $parts[$i]);
		}
		// Remove trailing :
		$unabbv = substr($new, 0, -1);
		return $unabbv;
	}
	/**
	 * Abbreviates an IPv6 address into shorthand form.
	 * Please note, this function is not as elegant as I would have
	 * liked, I had some issues with my regular expression, and I did
	 * the string parsing manually, additionally, I do not abbreviate
	 * the best way as for instance with 
	 * '2001:0db8:0000:ff00:0000:0000:0000:0000' Doing the last 4 sets
	 * of '0000' with ':' would be more efficient than the first, but
	 * I didn't feel like this was the focus of your excercise.
	 *
	 * @param string $address an IPv6 Address
	 * @return string an abbreviated IPv6 address
	 */
	public function abbreviateAddress($address)
	{
		$abbv = $address;
		// Check if we're already abbreviated
		if (strpos($abbv, "::") === FALSE)
		{
			// Split it up into logical groups
			$parts  = explode(":", $abbv);
			$nparts = array();
			$ignore = false;
			$done   = false;
			for ($i=0;$i<count($parts);$i++)
			{
				if (intval(hexdec($parts[$i])) === 0 && $ignore == false && $done == false)
				{
					$ignore   = true;
					$nparts[] = '';
					// This is because a 2 part array with '' and '0001' would have resulted in :0001 rather
					// than ::0001
					if ($i == 0)
						$nparts[] = '';
				}
				else if (intval(hexdec($parts[$i])) === 0 && $ignore == true && $done == false)
				{
					continue;
				}
				else if (intval(hexdec($parts[$i])) !== 0 && $ignore == true)
				{
					$done   = true;
					$ignore = false;
					$nparts[] = $parts[$i];
				}
				else
				{
					$nparts[] = $parts[$i];
				}
			}
			$abbv = implode(":", $nparts);
		}
		// Remove one or more leading zeroes
		$abbv = preg_replace("/:0{1,3}/", ":", $abbv);
		return $abbv;
	}
	/**
	 * Gets the interface count for a given prefix length
	 * 
	 * @param integer $prefix_len The prefix length
	 * @return string a formatted number of IPs in that prefix length
	 */
	public function getInterfaceCount($prefix_len)
	{
		$actual = pow(2, (128-$prefix_len));
		return number_format($actual);
	}
	/**
	 * Gets IP range information for a given address and prefix length
	 *
	 * @param string $address the IPv6 Address
	 * @param integer $prefix_len The prefix length
	 * @return array an array of information about the IP address range
	 */
	public function getAddressRange($address, $prefix_len)
	{
		// Unabbreviate it just in case this is called adhoc
		$unabbv = $this->unabbreviateAddress($address);
		$parts  = explode(":", $unabbv);
		// This is the start bit mask
		$bstring = str_repeat("1", $prefix_len) . str_repeat("0", 128-$prefix_len);
		// This is the end bit mask
		$estring = str_repeat("0", $prefix_len) . str_repeat("1", 128-$prefix_len);
		// I'm not sure I like doing this, but I am doing this out of abundance of
		// caution with PHP's data types
		$mins    = str_split($bstring, 16);
		$maxs    = str_split($estring, 16);
		$mb    = "";
		$start = "";
		$end   = "";
		for ($i = 0; $i < 8; $i++)
		{
			$min    = base_convert($mins[$i], 2, 16);
			$max    = base_convert($maxs[$i], 2, 16);
			$mb    .= sprintf("%04s", $min) . ':';
			$start .= dechex(hexdec($parts[$i]) & hexdec($min)) . ':';
			$end   .= dechex(hexdec($parts[$i]) | hexdec($max)) . ':';
		}
		$prefix_address = substr($mb, 0, -1);
		$start = substr($start, 0, -1);
		$start = $this->unabbreviateAddress($start);
		$end = substr($end, 0, -1);
		$end = $this->unabbreviateAddress($end);
		$ret = array(
				'prefix_address' => $prefix_address,
				'start_address'  => $start,
				'end_address'    => $end,
				);
		return $ret;
	}
}
