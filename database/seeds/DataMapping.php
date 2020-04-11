<?php

trait DataMapping
{
    
    protected $sensorTypes = [
			[
				'name' => 'Temperature', 
				'units' => [
					['Celsius degrees', 'ºC'], 
					['Fahrenheit degrees', 'ºF'],
					['Kelvin degrees', 'K']
				]
			],
			[
				'name' => 'Energy', 
				'units' => [
					['Joule', 'J'],
					['kilowatt-hour','kWh'],
					['British thermal unit', 'BTU']
				]
			],
			['name' => 'Humidity', 
				'units' => [
					['Relative Humidity', '%'],
					['Absolute Humidity', 'kg/m³']
				]
			],
			['name' => 'Voltage', 
				'units' => [
					['Volt', 'V']
				]
			],
			['name' => 'Current', 
				'units' => [
					['Ampere', 'A']
				]
			],
			['name' => 'Resistence', 
				'units' => [
					['Ohm', 'Omega']
				]
			],
			['name' => 'Wind speed', 
				'units' => [
					['Meters per second', 'm/s']
				]
			],
			['name' => 'CO2', 
				'units' => [
					['Parts per milion', 'ppp']
				]
			],
		];
}
