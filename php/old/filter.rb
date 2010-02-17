
@DIR="C:/Documents and Settings/cbeust/My Documents/perry/summaries"
#@DIR="C:/t/summaries"
@DATE='<span class="date">'
@TEXT='<span class="text">'
@AUTHOR='<span class="author">'
@ENGLISH_TITLE='<span class="english-title">'
@GERMAN_TITLE='<span class="german-title">'
@AUTHOR_TITLE='<span class="author">'

@END='</span>'

@DATES = Hash.new

class Heft
  attr_accessor :number, :date, :summary, :english_title, :german_title, :author
end

def convertDate(date)
  result = ''

  if date != nil
    result = date.chomp(",").split
    puts "#{result[3]}-#{result[1]}-#{result[2]}"
  end

  result
end

Dir.foreach(@DIR) { | file |
  if file.to_s =~ /.*html$/
    date = nil
    File.new(@DIR + "/" + file).each_line { | line |
      start = line.index(@DATE)
      if start != nil
        e = line.index("<", start)
        date = line[start + @DATE.size .. e - 1]
      end
    }

    number = file.to_s
    @DATES[number] = date
  end
}

def filterNumber(number)
  number.chomp(".html")
end

def filterTitle(title)
  title.delete("\n").gsub(/'/, "''")
end

def filterSummary(summary)
  summary.gsub(/'/, "''")
end

def extractTag(tag, content)
#  puts "EXTRACTING #{tag}"
  start = content.index(tag)
  if start != nil
    en = content.index(@END, start)

    if (en != nil)
      result = content[(start + tag.size) .. (en - 1)].delete("\n")
#    puts "#{start} #{en} #RESULT: #{result}"
      result
    else
      ""
    end
  else
    ""
  end
end

Dir.foreach(@DIR) { | file |
  if file.to_s =~ /.*html$/
    date = nil
    heft = Heft.new
    content = String.new
    File.new(@DIR + "/" + file).each_line { | line |
      content += line;
    }

    heft.date = extractTag(@DATE, content)
    heft.english_title = filterSummary(extractTag(@ENGLISH_TITLE, content))
    heft.german_title = filterSummary(extractTag(@GERMAN_TITLE, content))
    heft.author = filterSummary(extractTag(@AUTHOR, content))
    heft.summary = filterSummary(extractTag(@TEXT, content))

    number = file.to_s
    heft.number = filterNumber(number)
    @DATES[number] = heft
  end
}


@DATES.each { | k, v |
  puts "insert into summaries values('#{v.number}', '#{v.english_title}', 'Cedric Beust', 'x@y.com', '#{v.date}', '#{v.summary}');"
#  puts "insert into hefte value('#{v.number}', '#{v.german_title}', '#{v.author}', '#{v.date}');"
}

