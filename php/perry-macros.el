;; Macros to clean up Perry Rhodan translations from Power Translator

(cond
  ;; Mac
  ((equal "cbeust-macbookpro.local" (system-name)) (progn
    (setq system "mac")
    (setq german-top-dir "/Users/cbeust/Documents/perry-rhodan")))
  ;; PCW
  ((equal "CBEUST22-CORP" (system-name)) (progn
    (setq system "pcw")
    (setq top-dir "c:/Documents and Settings/cbeust/My Documents/Perry Rhodan/current")))
  ;; default
  (t (progn
    (setq system "other")
    (setq top-dir "unknown")))
)

(setq german-dir (concat top-dir "/1400-1499"))

(setq german-replacements '(
    "-" " - "
    "\\emdash" " - "
))

(setq english-dir (concat top-dir "/en"))

(setq english-replacements '(
    ;; longer strings first
    "her/it/them" "h_er"
    "her/its/their" "t_heir"
    "she/it/they" "s_he"
    "them/her/it" "t_hem"
    "her/them" "t_hem"
    "he/it" "h_e"
    "her/it" "h_er"
    "his/its" "h_is"
    "him/it" "h_im"
    "himself/itself" "h_imself"
    "itself/themselves" "i_tself"
    "she/it" "s_he"
    "she/they" "s_he"
    "them/her" "t_hem"
    "you/they" "t_hey"

    "h_er" "her"
    "h_e" "he"
    "h_is" "his"
    "h_im" "him"
    "i_tself" "itself"
    "s_he" "she"
    "t_heir" "their"
    "t_hem" "them"
    "t_hey" "they"
    "h_himself" "himself"

    "-loose" "less"
    "amounted" "counted"
    "antigravschacht" "antigrav shaft"
    "attendants sie" "wait"
    "area-ship" "spaceship"
    "befell" "happened to"
    "cell - vibration - assets - gate" "cell activator"
    "cell-assets-fool" "cell activator"
    "election" "choice"
    "expounded" "explained"
    "Galaktiker" "Galactics"
    "heaven" "sky"
    "husbands" "men"
    "is free with" "is going on with"
    "it gives" "there is"
    "long-distance-orientation" "long distance detection"
    "medo-roboter" "medo robot"
    "most upper" "supreme"
    "needed not" "didn't have"
    "orientation-screen" "detection screen"
    "respect" "detection"
    "property" "good"
    "properly had" "are right"
    "properly kept" "was right"
    "shot for him through the head" "occurred to him"
    "shot for her through the head" "occurred to her"
    "something is" "what is"
    "state security service" "stasis"
    "stylish" "send"
    "shelf-storage" "onboard computer"
    "suitor terraner the league" "league of the free Terrans"
    "tax-computer" "control computer"
    "umbrella" "screen"
    "use-" "mission "
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

(defun current-file ()
  "Return the filename (without directory) of the current buffer"
  (file-name-nondirectory (buffer-file-name (current-buffer)))
  )

(defun perry-replace-dir (file strings)
  (interactive)
  (find-file file)
  (beginning-of-buffer)

  (while strings
    (progn
      (perry-replace-strings (car strings) (car (cdr strings)))
      (setq strings (cdr (cdr strings)))))
  
  (write-file (concat english-dir "/_clean " (current-file)))
  (kill-buffer nil)
)

(defun log (s)
  (save-excursion
    (switch-to-buffer "*Deb*")
    (insert-string s)
    (insert-string "\n")))

(defun perry-replace-strings (from to)
  (interactive)
  (log (format "Replacing %s with %s" from to))
  (beginning-of-buffer)
  (while (search-forward from nil t) (progn
;;    (log "  Found match")
    (replace-match to))))

(defun debug ()
  (interactive)
  (beginning-of-buffer)
  (while (search-forward "her/them" nil t) (progn
;;    (log "  Found match")
    (replace-match "them"))))
  
