import java.util.regex.Matcher
import java.util.regex.Pattern

public class Perry {
  // Windows
  static def topDirWindows = "/Users/Cedric/Documents/perry-rhodan/"
  // Mac
  static def topDirMac = "/Users/cbeust/Documents/perry-rhodan/"

  static def topDir = topDirMac

  static def germanDir = topDir + "ge2/"
  static def outGermanDir = topDir + "ge2-clean/"
  static def englishDir = topDir + "en2/"
  static def outEnglishDir = topDir + "en2-clean/"

  def debug = true
  def verbose = true
  def key = "AIzaSyCay1CnJHuVpSBCiCLyfIrxZdH1PbEtWVY"

  def germanStrings = [
    "-" : " - ",
    "\\emdash" : " - ",
    //    "{\\\u8212\\\'97}" : " ",
    " - " : ""
  ]

  def englishStrings = [
    // longer strings first
    "her/it/them" : "h_er",
    "her/its/their" : "t_heir",
    "she/it/they" : "s_he",
    "them/her/it" : "t_hem",
    "her/them" : "t_hem",
    "he/it" : "h_e",
    "her/it" : "h_er",
    "his/its" : "h_is",
    "him/it" : "h_im",
    "himself/itself" : "h_imself",
    "itself/themselves" : "i_tself",
    "she/it" : "s_he",
    "she/they" : "s_he",
    "them/her" : "t_hem",
    "you/they" : "t_hey",

    "h_er" : "her",
    "h_e" : "he",
    "h_is" : "his",
    "h_im" : "him",
    "i_tself" : "itself",
    "s_he" : "she",
    "t_heir" : "their",
    "t_hem" : "them",
    "t_hey" : "they",
    "h_himself" : "himself",

    ", that" : " that",
    "-loose" : "less",
    "a moment once" : "hold on",
    "amounted" : "counted",
    "antigravschacht" : "antigrav shaft",
    "area-harbor" : "space port",
    "area-ship" : "spaceship",
    "artgenossen" : "compatriot",
    "attendants sie" : "wait",
    "attendant" : "wait",
    "attendants still" : "wait",
    "befell" : "happened to",
    "cross-ion" : "Querion",

    "draw lots" : "let's go", // los jetzt
    "draws lots" : "less",
    "cantarische" : "Cantaros",
    "cell - vibration - assets - gate" : "cell activator",
    "cell-assets-fool" : "cell activator",
    "cell-assets-gate" : "cell activator",
    "cell-assets-goal" : "cell activator",
    "clear become" : "figure out", // klarwerden
    "drive around" : "turn around",
    "drives around" : "turns around",
    "drove around" : "turned around",
    "chronopuls" : "Chronopulse",
    "debit that is" : "does that mean", // Soll das heissen
    "election" : "choice",
    "embankment" : "wall",
    "estuary" : "opening",
    "expounded" : "explained",
    "fauchte" : "hissed",
    "free-dealer" : "Free Trader",
    "free dealer" : "Free Trader",
    "gucky" : "Pucky",
    "heavily" : "hardly",
    "hyper-area" : "hyperspace",
    "it gives" : "there is",
    "it gave" : "there was",
    "Galaktiker" : "Galactics",
    "Kugelsternhaufens" : "globular cluster",
    "Haluter" : "Halutian",
    "heaven" : "sky",
    "husbands" : "men",
    "innern" : "inside",
    "introduce itself" : "imagine",
    "is free with" : "is going on with",
    "it gives" : "there is",
    "long-distance-orientation" : "long distance detection",
    "marked" : "Excellent", // Ausgezeichnet
    "marsianische" : "Martian",
    "medo-roboter" : "medo robot",
    "mighty-ness-concentration" : "sphere of influence",
    "most upper" : "supreme",
    "nature" : "creature",
    "needed not" : "didn't have",
    "opposite" : "against",
    "orientation" : "detection",
    "Pedokr=C3=A4fte" : "Pedopower",
    "reputation" : "shout",
    "respect" : "detection",
    "property" : "good",
    "properly had" : "are right",
    "properly kept" : "was right",
    "race tschubai" : "Ras Tschubai",
    "Raumhafens" : "space port",
    "robotische" : "robotized",
    "sat down in connection with" : "opened a connection with",
    "sentence" : "step",
    "shot for him through the head" : "occurred to him",
    "shot for her through the head" : "occurred to her",
    "something is" : "what is",
    "space-harbor" : "space port",
    "state security service" : "stasis",
    "stylish" : "send",
    "shelf-storage" : "onboard computer",
    "sturgeon-impulse" : "surge pulse",
    "suitor terraner the league" : "league of the free Terrans",
    "tax-computer" : "control computer",
    "Terraner" : "Terran",
    "Terranerin" : "Terran",
    "toot sorry for me" : "I'm sorry",
    "toot this" : "sorry",
    "to the thunder-eather" : "the hell",
    "umbrella" : "screen",
    "under-light-fast" : "sublight speed",
    "what is free" : "what is going on",
    "what was free" : "what happened",
    "whether" : "maybe",
    "you you" : "you",
    "still another" : "neither a",

    "ischen" : "ic",
    "ische" : "ic",
    "isch" : "ic",

    // RTF clean up
    "[a-zA-Z]\\par" : ""
  ]



  void cleanGerman()
  {
    if (false) {
      replace(new File(germanDir + "a.rtf"))
    }
    else {
      new File(germanDir).eachFileRecurse({ file ->
        replaceStrings(file, germanStrings, outGermanDir)
      })
    }
  }

  void cleanEnglish() {
    if (false) {
      replaceStrings(new File(englishDir + "a.rtf"), englishStrings, outEnglishDir)
    }
    else {
      new File(englishDir).eachFileRecurse({ file ->
        replaceStrings(file, englishStrings, outEnglishDir)
      })
    }
  }

  public replaceStrings(file, strings, outDir) {
    println("Replacing in file:" + file + " outDir:" + outDir)

    def fileText = file.text
    for (s in strings) {
      fileText = replaceAllWithCase(fileText, s.key, s.value)
    }
    def outFile = new File(outDir + file.name)
    outFile.delete()

    p("Writing " + outFile.getAbsolutePath())
    outFile << fileText
  }


  public translateDirectory(fromDir, toDir) {
    new File(fromDir).eachFileRecurse({ file ->
      def fileText = file.text
      def translation = translateLargeText(fileText)

      def outFile = new File(toDir + file.name)
      outFile.delete()
      p("Writing " + outFile.getAbsolutePath())
      outFile << fileText
    })
  }

  public translateLargeText(entireText) {
    def MAX = 800
    def buffer = new StringBuilder()
    def sentences = entireText.split("\\.")
    def translatedSentences = new StringBuilder()
    def count = 0

    for (sentence in sentences) {
      count = count + sentence.size()
      if (sentence.size() > MAX) {
        println("Skipping long sentence:" + sentence)
      }
      else if (buffer.size() + sentence.size() < MAX) {
        buffer = buffer + sentence + ". "
      }
      else {
        println("Translated:" + count)
        Thread.sleep(200)
        def translation = translateSmallText(buffer.toString()) + " "
        if (translation != null) {
          translatedSentences.append(translation)
          buffer = new StringBuilder()
        }
        else {
          return translatedSentences
        }
      }
    }

    translatedSentences.append(translateSmallText(buffer.toString()))

    return translatedSentences
  }

  public translateSmallText(text) {
    def result = new StringBuilder()
    def encodedText = URLEncoder.encode(text, "UTF-8")
    def translateUrl =
        "https://www.googleapis.com/language/translate/v2?key=${key}&source=de&t=arget=en&q=${encodedText}".toURL()
    //      new URL("http://www.google.com/uds/Gtranslate?v=1.0&langpair=de%7Cen&q=${encod=edText}")
    // "http://www.google.com/uds/Gtranslate?v=1.0&langpair=de%7Cen&q=${encod=edText}".toURL()
    //    def translateUrl = "https://www.googleapis.com/language/translate/v2?key=${key}&q=${text}&s=ource=de&target=en"
    //    def translateUrl = "http://www.google.com/uds/Gtranslate?v=1.0&q=${text}&langpair=${lang}=%7C${targetLang}".toURL()
    //    p("URL: " + text.size() + " " + translateUrl)
    //    p("Text:" + translateUrl.text)
    try {
      def urlText = translateUrl.text
      def translationResponse = jsonToGroovyMap(urlText)
      if (translationResponse != null) {
        for (s in translationResponse.data.translations) {
          result.append(s.translatedText)
        }
        //      if (translationResponse.responseData != null)
        //      {
        //        result = translationResponse.responseData.translatedText
        //      }
        //      else
        //      {
        //        println("Error found: " + translationResponse.responseDetails)
        //      }
      }
      else {
        println("Null response to " + translateUrl)
      }
    }
    catch(IOException ex) {
      println("Error: " + ex)
    }
    return result.toString()
  }

  /**
   * Converts a JSON string into a Groovy map.
   * The difference lies in the difference in map notation: {:} in JSON vs[:] in Groovy
   */
  def jsonToGroovyMap(jsonString) {
    new GroovyShell().evaluate(jsonString.replaceAll(/}/,
        ']').replaceAll(/\{/, '['))
  }

  def p(s) {
    if (verbose) println("[Perry] " + s)
  }

  private replaceAllWithCase(string, pattern, rep)
  {
    def p = Pattern.compile(Matcher.quoteReplacement(pattern), Pattern.CASE_INSENSITIVE);
    def m = p.matcher(string);

    def sb = new StringBuffer();

    while (m.find()) {
      def g = m.group()
      m.appendReplacement(sb, Matcher.quoteReplacement(matchCase(rep, m.group())));
    }
    m.appendTail(sb);

    return sb.toString()
  }

  /**
   * "ab" "cd" -> "cd"
   * "Ab" "cd" -> "Cd"
   * "AB" "cd" -> "CD"
   */
  private matchCase(string, out)
  {
    def result = new StringBuilder()
    def c1 = string.getChars()
    def c2 = out.getChars()
    for (def i = 0; i < c1.length; i++)
//    for (i in 0..(c1.length - 1))
    {
      def c = c1[i]
      if (i < c2.length)
      {
        if (Character.isLowerCase(c2[i])) c = c1[i].toLowerCase()
        else if (Character.isUpperCase(c2[i])) c = c1[i].toUpperCase()
      }
      result.append(c1[i])
    }

    return result.toString()
  }

  private test()
  {
    assert new Perry().matchCase("abc", "Abc") == "Abc"
    assert new Perry().matchCase("abc", "ABC") == "ABC"
    assert new Perry().replaceAllWithCase("ABC Abc abc", "ABC", "foo") == "FOO Foo foo"

    assert new Perry().replaceAllWithCase("her/it/them did something", "her/it/them", "h_er") \
      == "h_er did something"
    assert new Perry().replaceAllWithCase("Her/it/them did something", "her/it/them", "h_er") \
      == "H_er did something"
    assert new Perry().replaceAllWithCase("His/its family", "his/its", "h_is") \
      == "H_is family"
  }

  static void main(def args) {
    //    def text = new File(germanDir + "a.txt").text
    //    def translation = new Perry().processHeft(text)
    //    println(translation)

    //    new Perry().cleanGerman()
    //    new Perry().translateLargeText(new File(germanDir + "a.txt").text)
    //    new Perry().translateDirectory(outGermanDir, englishDir)
//    new Perry().test()
    new Perry().cleanEnglish();
  }
}