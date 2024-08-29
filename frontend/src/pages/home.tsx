import { Box, Container, Typography } from '@mui/material'
import type { NextPage } from 'next'
import ArticleCard from '@/components/ArticleCard'

type ArticleProps = {
  id: number
  title: string
  content: string
}

const Index: NextPage = () => {
  const articles: ArticleProps[] = [
    {
      id: 1,
      title: '1番目の記事',
      content: '記事の要約1',
    },
    {
      id: 2,
      title: '2番目の記事',
      content: '記事の要約2',
    },
    // 他の記事データを追加...
  ]

  return (
    <Box sx={{ backgroundColor: 'white', minHeight: '100vh', p: 4 }}>
      <Typography
        variant="h3"
        component="h1"
        sx={{ textAlign: 'center', mb: 2, color: 'text.primary' }}
      >
        オススメ記事
      </Typography>
      <Typography
        variant="body1"
        component="p"
        sx={{ textAlign: 'center', mb: 4, color: 'text.primary' }}
      >
        あなたが気になる記事を選ぼう
      </Typography>
      <Container maxWidth="md">
        {articles.map((article) => (
          <Box key={article.id} sx={{ mb: 4, bgcolor: 'white' }}>
            <ArticleCard {...article} />
          </Box>
        ))}
      </Container>
    </Box>
  )
}

export default Index
