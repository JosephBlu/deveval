
<phpunit>
	<testsuites>
		<testsuite name="Email Data Design">
			<file>email.php</file>
		</testsuite>
	</testsuites>
	<filter>
		<whitelist processUncoveredFilesFromWhitelist="true">
			<directory suffix=".php">../</directory>
		</whitelist>
	</filter>

</phpunit>
