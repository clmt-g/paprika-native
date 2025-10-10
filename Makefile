.PHONY: clean sonarqube

clean:
	echo "cleaning"
	clear

sonarqube:
	sonar-scanner \
		-Dsonar.projectKey=paprika-t4s \
		-Dsonar.sources=app \
		-Dsonar.host.url=http://sonarqube.ad.supalta.com \
		-Dsonar.token=sqp_358057e7b0b8fa5c812c0902b938682c5642b310