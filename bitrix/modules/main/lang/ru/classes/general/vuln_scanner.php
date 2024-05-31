<?
$MESS["VULNSCAN_SIMILAR"] = "Аналогично";
$MESS["VULNSCAN_REQUIRE"] = "Необходимые условия";
$MESS["VULNSCAN_FILE"] = "Файл";
$MESS["VULNSCAN_XSS_NAME"] = "Cross-Site Scripting";
$MESS["VULNSCAN_XSS_HELP"] = "Межсайтовый скриптинг (XSS) уязвимость возникает тогда, когда данные, принятые от пользователя, выводятся в браузер без надлежащей фильтрации. Уязвимость может быть использована для изменения вида HTML страниц уязвимого сайта в контексте браузера целевого пользователя, похищения COOKIE данных браузера целевого пользователя, с последующим внедрением в его сессию, под его учетной записью.";
$MESS["VULNSCAN_XSS_HELP_SAFE"] = "Использовать <b>htmlspecialcharsbx</b>. Параметры тегов с динамическими значениями ограничивать двойными кавычками. Принудительно добавлять протокол (http), где это необходимо, для значений параметров тегов, таких как href или src.";
$MESS["VULNSCAN_HEADER_NAME"] = "HTTP Response Splitting";
$MESS["VULNSCAN_HEADER_HELP"] = "Злоумышленник, внедряя произвольный заголовок в HTTP ответ, может выполнить атаку с использованием перенаправления или же вставкой произвольного HTML/JS кода. Актуально для PHP версии ниже 5.4";
$MESS["VULNSCAN_HEADER_HELP_SAFE"] = "Рекомендуется фильтровать переводы строк перед выводом в заголовок ответа.";
$MESS["VULNSCAN_DATABASE_NAME"] = "SQL Injection";
$MESS["VULNSCAN_DATABASE_HELP"] = "Классическая уязвимость, которая связана с недостаточной фильтрацией данных, используемых в SQL запросах. Это критическая уязвимость приводит к тому, что нападающий может выполнить произвольные SQL запросы к базе данных. Например получить значение произвольных таблиц, изменить некоторые значения (сделать себя админом), удалить данные, и всю базу данных целиком.";
$MESS["VULNSCAN_DATABASE_HELP_SAFE"] = "Для числовых данных, явно приводить значение к нужному типу (int, float и т.п.), для строковых данных, обрабатывать данные при помощи mysql_escape_string, \$DB->ForSQL() и т.п.. А также, контролировать длину данных.";
$MESS["VULNSCAN_INCLUDE_NAME"] = "File Inclusion";
$MESS["VULNSCAN_INCLUDE_HELP"] = "Злоумышленник может подключать локальные/удаленные файлы или же читать произвольные файлы ресурса.";
$MESS["VULNSCAN_INCLUDE_HELP_SAFE"] = "Рекомендуется как минимум делать нормализацию пути перед их использованием.";
$MESS["VULNSCAN_EXEC_NAME"] = "Выполнение произвольных команд";
$MESS["VULNSCAN_EXEC_HELP"] = "Уязвимость связана с недостаточно фильтрацией данных, вставляемый в аргумент функции <b>system</b> и т.п. Например <b>system(\"ping \$_GET['host']\");</b> Нападающий сможет выполнить произвольный код в системе.";
$MESS["VULNSCAN_EXEC_HELP_SAFE"] = "Проводить явную проверку допустимости значения таких переменных из явно определенного разрешенного множества значений. Например, разрешать только латинские буквы и цифры, и т.п. Множество должно быть задано исходя из поставленных задач. Также, можно использовать функции типа escapeshellcmd и escapeshellarg.";
$MESS["VULNSCAN_CODE_NAME"] = "Выполнение произвольного кода";
$MESS["VULNSCAN_CODE_HELP"] = "Злоумышленник может внедрить и выполнить произвольный PHP код.";
$MESS["VULNSCAN_CODE_HELP_SAFE"] = "Фильтровать пользовательский ввод, например при помощи <b>EscapePHPString</b>";
$MESS["VULNSCAN_POP_NAME"] = "Сериализация данных";
$MESS["VULNSCAN_POP_HELP"] = "Десериализация пользовательских данных может быть достаточно опасна.";
$MESS["VULNSCAN_OTHER_NAME"] = "Потенциальное изменение логики работы";
$MESS["VULNSCAN_OTHER_HELP"] = "Описание отсутствует";
$MESS["VULNSCAN_UNKNOWN"] = "Подозрение на уязвимость";
$MESS["VULNSCAN_UNKNOWN_HELP"] = "Описание отсутствует";
$MESS["VULNSCAN_HELP_INPUT"] = "Источник";
$MESS["VULNSCAN_HELP_FUNCTION"] = "Функция/метод";
$MESS["VULNSCAN_HELP_VULNTYPE"] = "Тип уязвимости";
$MESS["VULNSCAN_HELP_SAFE"] = "Как защищаться";
$MESS["VULNSCAN_FIULECHECKED"] = "Проверенно файлов: ";
$MESS["VULNSCAN_VULNCOUNTS"] = " Найдено потенциальных проблем: ";
$MESS["VULNSCAN_DYNAMIC_FUNCTION"] = "Вызов динамической функции!";
$MESS["VULNSCAN_EXTRACT"] = "Ранее инициализированные переменные могут быть переопределены!";
$MESS["VULNSCAN_TOKENIZER_NOT_INSTALLED"] = "PHP расширение tokenizer не включено, пожалуйста включите его для завершения тестирования.";
?>