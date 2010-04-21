;;
;; Macros to clean up Perry Rhodan translations from Power Translator
;; 
;; To clean binary characters:
;; cat ~/t/dump|perl -pi -e "s/\xc3\xa2\xe2\x82\xac\xe2\x84\xa2/\\\'/g" >~/t/dump3
;;
;; To run: M-x german or M-x english
;;

(setq log-p ())

(cond
  ;; Mac
  ((equal "cbeust-macbookpro.local" (system-name)) (progn
    (setq system "mac")
    (setq top-dir "/Users/cbeust/Documents/Perry Rhodan/current")))
  ;; PCW
  ((equal "CBEUST22-CORP" (system-name)) (progn
    (setq system "pcw")
    (setq top-dir "c:/Documents and Settings/cbeust/My Documents/Perry Rhodan/current")))
  ;; PCH
  ((equal "LEFT" (system-name)) (progn
    (setq system "pch")
    (setq top-dir "c:/Users/cbeust/My Documents/Perry Rhodan/current")))
  ;; default
  (t (progn
    (setq system "other")
    (setq top-dir "unknown")))
)

(if t (progn
    (setq german-dir (concat top-dir "/ge"))
    (setq english-dir (concat top-dir "/en")))
  (setq german-dir (concat top-dir "/tmp"))
  (setq english-dir (concat top-dir "/tmp"))
)

(setq german-replacements '(
    "\\-" ""
    "-" " - "
    "\\emdash" " - "
    "{\\u8212\\'97}" " "
    "\\'bb" "\""
    "\\'ab" "\""
))


(setq english-replacements '(
    ;; longer strings first			    
    "/" "é"
    "heréitéthem" "her"
    "heréitsétheir" "their"
    "sheéitéthey" "she"
    "theméheréit" "them"
    "heréthem" "them"
    "heéit" "he"
    "heréit" "her"
    "hiséits" "his"
    "himéit" "him"
    "himselféitself" "himself"
    "itselféthemselves" "itself"
    "sheéit" "she"
    "sheéthey" "she"
    "theméher" "them"
    "theméyou" "them"
    "youéthey" "they"
    "yourétheir" "your"

    "é" "/"

;;    "h_er" "her"
;;    "h_e" "he"
;;    "h_is" "his"
;;    "h_im" "him"
;;    "i_tself" "itself"
;;    "s_he" "she"
;;    "t_heir" "their"
;;    "t_hem" "them"
;;    "t_hey" "they"
;;    "h_himself" "himself"

    ", that" " that"
    "-loose" "less"
    "a moment once" "hold on"
    "amounted" "counted"
    "antigravschacht" "antigrav shaft"
    "area-harbor" "space port"
    "area-ship" "spaceship"
    "artgenossen" "compatriot"
    "assets-gate" "cell activator"
    "attendants sie" "wait"
    "attendant" "wait"
    "attendants still" "wait"
    "ball-star-pile" "globular cluster" ;; Kugelsternhaufen
    "befell" "happened to"
    "blind about after" "return to"
    "cross-ion" "Querion"
    "draw lots" "let's go" ;; los jetzt
    "draws lots" "less"
    "cantarische" "Cantaros"
    "cell-assets-fool" "cell activator"
    "cell-assets-gate" "cell activator"
    "cell-assets-goal" "cell activator"
    "cell - vibration - assets - gate" "cell activator"
    "cell-vibration-assets-fool" "cell activator"
    "cell-vibration-assets-goal" "cell activator"
    "clear become" "figure out" ;; klarwerden
    "country" "land"
    "drive around" "turn around"
    "drives around" "turns around"
    "drove around" "turned around"
    "chronopuls" "Chronopulse"
    "debit that is" "does that mean" ;; Soll das heissen
    "election" "choice"
    "embankment" "wall"
    "estuary" "opening"
    "expounded" "explained"
    "fauchte" "hissed"
    "free-dealer" "Free Trader"
    "free dealer" "Free Trader"
    "gucky" "Pucky"
    "heavily" "hardly"
    "hyper-area" "hyperspace"
    "in agreement" "agreed"
    "in order" "alright"
    "introduced itself" "imagined"
    "it gives" "there is"
    "it gave" "there was"
    "Galaktiker" "Galactics"
    "group pubs" "globular cluster"
    "Kugelsternhaufens" "globular cluster"
    "Haluter" "Halutian"
    "heaven" "sky"
    "husbands" "men"
    "innern" "inside"
    "introduce himself" "imagine"
    "introduce itself" "imagine"
    "is free with" "is going on with"
    "it gives" "there is"
    "like many" "how many"
    "long-distance-orientation" "long distance detection"
    "marked" "Excellent" ;; Ausgezeichnet
    "marsianische" "Martian"
    "medo-roboter" "medo robot"
    "mighty-ness-concentration" "sphere of influence"
    "most upper" "supreme"
    "nature" "creature"
    "needed not" "didn't have"
    "one writes" "in"
    "orientation" "detection"
    "Pedokräfte" "Pedopower"
    "reputation" "shout"
    "respect" "detection"
    "property" "good"
    "properly have" "are right"
    "properly had" "are right"
    "properly kept" "was right"
    "pubs group" "globular cluster"
    "race tschubai" "Ras Tschubai"
    "removes" "away"
    "Raumhafens" "space port"
    "robotische" "robotized"
    "sat down in connection with" "opened a connection with"
    "sentence" "step"
    "shot for him through the head" "occurred to him"
    "shot for her through the head" "occurred to her"
    "something is" "what is"
    "space-harbor" "space port"
    "state security service" "stasis"
    "stylish" "send"
    "shelf-storage" "onboard computer"
    "sturgeon-impulse" "surge pulse"
    "suitor terraner the league" "league of the free Terrans"
    "tax-computer" "control computer"
    "Terraner" "Terran"
    "Terranerin" "Terran"
    "toot sorry for me" "I'm sorry"
    "toot this" "sorry"
    "to the thunder-eather" "the hell"
    "Tschubai races" "Ras Tschubai"
    "umbrella" "screen"
    "under-light-fast" "sublight speed"
    "what is free" "what is going on"
    "what was free" "what happened"
    "whether" "maybe"
    "you you" "you"

    " - " "-"

    "area" "space"
))

(defun german ()
  "The main entry point to clean up all the issues found in the `german-dir` directory"
  (interactive)
  (execute 'perry-replace-dir german-dir german-replacements))

(defun english ()
  "The main entry point to clean up all the issues found in the `english-dir` directory"
  (interactive)
  (execute 'perry-replace-dir english-dir english-replacements))

(defun execute (action dir strings)
  "Apply the action to each file in the directory with the given strings"
  (interactive)
  (progn
    (setq lst (directory-files dir () "rtf$"))
      (while lst
         (setq file (car lst))
	 (log (concat "Found file " file))
         (setq lst (cdr lst))
         (if (not (or (string-match "~$" file) (member file '("." ".."))))
           (funcall action dir file strings)))))

(defun current-file ()
  "Return the filename (without directory) of the current buffer"
  (file-name-nondirectory (buffer-file-name (current-buffer)))
  )

(defun perry-replace-dir (dir file strings)
  (interactive)
  (log (concat "perry-replace-dir dir:" dir " file:" file))
  (find-file (concat dir "/" file))
  (beginning-of-buffer)

  (while strings
    (progn
      (perry-replace-strings (car strings) (car (cdr strings)))
      (setq strings (cdr (cdr strings)))))

  (log (concat "Writing file:" (concat dir "-clean/" file)))
  (write-file (concat dir "-clean/" file))
  (kill-buffer nil)
)

(defun log (s)
  (if log-p (progn
    (save-excursion
      (switch-to-buffer "*Deb*")
      (insert-string s)
      (insert-string "\n")))))

(defun perry-replace-strings (from to)
  (interactive)
  (log (format "Replacing %s with %s" from to))
  (beginning-of-buffer)
  (while (search-forward from nil t) (progn
    (log "  Found match")
    (replace-match to))))

(defun debug ()
  (interactive)
  (beginning-of-buffer)
  (while (search-forward "heréit" nil t) (progn
    (log "  Found match")
    (replace-match "h_e"))))
