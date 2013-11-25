function anti_piracy(key){
	if(key){
		var content = '<div style="width:600px;font-size:18px;text-align:center;line-height:30px;padding:15px;"><h2>糟糕了！</h2>	<p>你貌似是从异次元空间来到本站的吧？</p>	<p>这可真是太奇怪了！为什么呢？</p>	<p>貌似是异次元的网站<font color="red">引用了本站链接却没有加上版权声明呢！</font></p>	<p>既然这样的话，那就由我来帮他做个声明吧！</p>	<p>咳咳！<strong>本站是由Hs提出创意，并由ITJesse协助一同纯手打开发完成</strong></p>	<p>旨在方便老师同学们的日常生活的一个多功能平台</p><p>同时需要声明的是，湖工大查分客户端（现已下线，将被本平台替代）</p><p>也是由我ITJesse和Hs共同开发</p>	<p>本站大部分源代码遵循GPL v2协议，小部分遵循GPL v3协议</p>	<p>因此，你们可以在我的开源项目库中找到本站的完整源代码</p>	<p>（将会在全部开发结束后公布）</p>	<p>同时，这也意味着，你可以任意引用本站地址</p>	<p>或引用，修改，重新发布源代码，这些均不用经过我本人的同意</p>	<p><font color="red">但是有一点请注意</font></p>	<p>请不要删除版权声明，并在引用网址时也请加上完整的版权声明</p>	<p>如果被我发现有人违反上面的约定（很难发现吧kuso！）</p>	<p>我有权终止异空间的访问权限（我也只能这么做了。。）</p>	<p><font color="red"><strong>最后，我还是相信，程序员都是有爱的！</strong><font></p></div>';
		$.layer({
			type: 1,
			title: false,
			closeBtn : [0 , true],
			border : [5, 0.5, '#666', true],
			offset: ['20px',''],
			move: ['.juanmove', true],
			area: ['630px','auto'],
			page: {
				html: content
			}
		});
	}
}