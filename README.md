# FileRSS

FileRSS is a simple php script to generate an RSS feed using the filesystem.  
With a subtree like :

    dir/
        file1
        file2
        file3

FileRSS will create a feed named “dir” with 3 items named “file1..3”.
And the content, will be the content of the file.

My use case is to provide an alternative way to get notifications when my mail system is down.

# Install

Just copy the php script and edit the global variables at the beginning.

