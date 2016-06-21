require 'html/proofer'

task :rebuild do
  sh "rm -rf _site"
  sh "bundle exec jekyll build"
end

task :htmlproofer => :rebuild do
  ignored = [
  ]
  HTML::Proofer.new("./_site", 
    typhoeus: {ssl_verifypeer: false, timeout: 30}, 
    url_ignore: ignored, 
    check_html: true, 
    assume_extension: ".html").run
end

require 'rspec/core/rake_task'
RSpec::Core::RakeTask.new(:spec => :rebuild)

task :default => [:spec, :htmlproofer]