;; Macros to clean up Perry Rhodan translations from Power Translator

(if
  ;; Mac
  (equal "cbeust-macbookpro.local" (system-name)) (progn
    (setq system "mac")
    (setq german-top-dir "/Users/cbeust/Documents/perry-rhodan"))
  ;; PC1
  (equal "CBEUST22-CORP" (system-name)) (progn
    (setq system "pcw")
    (setq german-top-dir "c:/Documents and Settings/cbeust/My Documents/Perry Rhodan"))
  ;; default
  (progn
    (setq system "other")
    (setq german-top-dir "unknown"))
)

(setq german-dir "c:/Users/cbeust/Documents/perry-rhodan/2400-2499")

(setq german-replacements '(
    "-" " - "
    "\\emdash" " - "
))

(setq english-dir "c:/Users/cbeust/Documents/perry-rhodan/de to en Translation of 2400-2499")

(setq english-replacements '(
    "-loose" "less"
    "amounted" "counted"
    "attendants sie" "wait"
    "area-ship" "spaceship"
    "befell" "happened to"
    "cell - vibration - assets - gate" "cell activator"
    "cell-assets-fool" "cell activator"
    "expounded" "explained"
    "her/its/their" "their"
    "her/them" "them"
    "he/it" "he"
    "her/it" "her"
    "her/it/them" "her"
    "his/its" "his"
    "him/it" "him"
    "husbands" "men"
    "is free with" "is going on with"
    "it gives" "there is"
    "itself/themselves" "itself"
    "respect" "detection"
    "property" "good"
    "properly had" "are right"
    "something is" "what is"
    "state security service" "stasis"
    "she/it" "she"
    "she/they" "she"
    "shelf-storage" "onboard computer"
    "suitor terraner the league" "league of the free Terrans"
    "tax-computer" "control computer"
    "them/her/it" "them"
    "them/her" "them"
    "umbrella" "screen"
    "use-" "mission "
    "you/they" "they"
    "You/they" "They"
))

(defun german ()
  (interactive)
  (execute 'perry-replace-dir german-dir german-replacements))

(defun english ()
  (interactive)
  (execute 'perry-replace-dir english-dir english-replacements))

(defun execute (action dir strings)
  (interactive)
  (progn
    (setq lst (directory-files dir))
      (while lst
         (setq file (car lst))
         (setq lst (cdr lst))
         (if (not (or (string-match "~$" file) (member file '("." ".."))))
           (funcall action (concat dir "/" file) strings)))))

(defun perry-replace-dir (file strings)
  (interactive)
  (find-file file)
  (beginning-of-buffer)

  (while strings
    (progn
      (perry-replace-strings (car strings) (car (cdr strings)))
      (setq strings (cdr (cdr strings)))))
  
  (save-buffer))

(defun perry-replace-strings (from to)
  (interactive)
  (beginning-of-buffer)
  (while (re-search-forward from nil t)
    (replace-match to)))
  
