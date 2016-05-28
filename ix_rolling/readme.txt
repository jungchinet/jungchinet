/**
 * jQuery vertical scrolling plugin
 *
 * Author : eyesonlyz(eyesonlyz@nate.com)
 * Copyright (c) 2011-2012 eyesonlyz
 * Craeted : 2011-09-25
 * License : GPL
 * Preview : http://ezpress.phps.kr/ix_rolling/
 * Twitter : http://twitter.com/eyesonlyz
 *
 * image license
 * sns icon : Macchiato – Social http://19eighty7.com/ GPL
 */ 

ChangeLog

Version 0.7.1 (2013-01-10)
	- twitter user uri 변경
	- twitter user_timeline cache 추가
	- youtube 사용자 video 탬플릿 추가
Version 0.6.1 (2012-09-18)
	- iframe 용 코드 추가
	- gnu4 latest skin 추가 (ix_rolling)

Version 0.6 (2012-09-17)
	- 페이스북 - 페이지아이디를 통한 롤링 추가
	- 트위터 - reply, retweet, favorite 링크추가
	- XML 데이타 롤링시 302 (http redirect) 버그 수정

Version 0.5 (2012-07-01)
 	- 그누보드 등 데이타 파서 파일 옵션 추가 : options.data_parser [default=parser_gnu4.php] ...
 		- 로컬파서를 사용할경우(gnu4,xml,tf) parser 파일을 사용자화하여 call 할수 있다
 	- 각 탬플릿 서버 지원여부 표시 : check_server.php
 	- 이전,다음 로링 버튼 추가
 	- tf 탬플릿 추가 (twitter,facebook,yozm)
 	- css,js minify 파일 제공
 
Version 0.4 (2012-01-31)
	- XML 탬플릿 추가
		- ATOM 1.0, RSS 2.0 지원
	- jquery 1.5 이하버전 사용시 버그픽스

 Version 0.2 (2012-01-07) 

	- 페이스북 검색(post) 롤링 추가
	- 트위터 타임라인(user_timeline) 최신글 롤링 추가 
	- 데이타 파싱을 탬플릿으로 분리
	- 가장최근글 하일라이트
	- 본문 자동링크 강화
	- 작성시간 실시간 업데이트
	- 대기포지션을 통한 시간정렬 강화
	- 메세지 박스 추가 (오류,대기갯수 등 표시)

 Version 0.1 (2011-09-25) 

	- 배포
	- 트위터 검색 그누보드 최신글 롤링
